const express = require('express')
const path = require('path')
const PORT = process.env.PORT || 5000
const cool = require('cool-ascii-faces');
const axios = require('axios');

const currencyRate = (pair) => {
  const key = 'aa66f73f89767803319f';
  return axios.get(`https://free.currconv.com/api/v7/convert?q=${pair}&compact=ultra&apiKey=${key}`)
    .then(({data}) => {
      console.log(data);
      return data[pair];
    })
}

const mBitcoin = cripto => axios.get(`https://www.mercadobitcoin.net/api/${cripto}/ticker`)
  .then(({data}) => {
    console.info(data);
    const mean = (parseFloat(data.ticker.last) + parseFloat(data.ticker.high) + parseFloat(data.ticker.low))/3;
    return mean.toFixed(3);
  });

const bTrade = cripto => axios.get(`https://api.bitcointrade.com.br/v2/public/BRL${cripto}/ticker`)
  .then(({data}) => {
    const ticker = data.data;
    console.info(ticker);
    const mean = (parseFloat(ticker.last) + parseFloat(ticker.high) + parseFloat(ticker.low))/3;
    return mean.toFixed(3);
  });

const tWise = (source, target) => {
  const token = process.env.WISE_API_TOKEN;
  const config = {
    headers: { Authorization: `Bearer ${token}` }
  };

  return axios.get(`https://api.transferwise.com/v1/rates?source=${source}&target=${target}`, config)
    .then(function ({data}) {
      console.log(data);
      return data[0].rate;
    })
}


express()
  .use(express.static(path.join(__dirname, 'public')))
  .set('views', path.join(__dirname, 'views'))
  .set('view engine', 'ejs')
  .get('/', (req, res) => res.render('pages/index'))
  .get('/cool', (req, res) => res.send(process.env.WISE_API_TOKEN))
  .listen(PORT, () => console.log(`Listening on ${ PORT }`))

const { Telegraf } = require('telegraf')
const bot = new Telegraf(process.env.TG_TOKEN)
bot.start((ctx) => ctx.reply('Bem-vindo ao robô do Investidor'))
bot.help((ctx) => ctx.reply('Send me a sticker'))
bot.on('sticker', (ctx) => ctx.reply('👍'))
bot.hears('hi', (ctx) => ctx.reply('Hey there'))

bot.on('text', (ctx) => {
  console.info(ctx.update.message);
  mBitcoin('BTC').then(function (data) {
    ctx.replyWithHTML(`BTC mercadobitcoin <b>${data}</b>`)
  })

  bTrade('BTC').then(function (data) {
    ctx.replyWithHTML(`BTC BTrade <b>${data}</b>`)
  });

  mBitcoin('XRP').then(function (data) {
    ctx.replyWithMarkdown(`XRP mercadobitcoin ***${data} BRL***`);
  })

  tWise('EUR', 'BRL').then((data) => {
    ctx.replyWithMarkdown(`EUR/BRL WISE ***${data}***`);
  });

  currencyRate('EUR_USD').then(function (data) {
    ctx.reply(`EUR/USD ${data}`)
  });

  currencyRate('USD_BRL').then(function (data) {
    ctx.reply(`BRL/USD ${data}`)
  });

  currencyRate('EUR_BRL').then(function (data) {
    ctx.reply(`EUR/BRL ${data}`)
  });
});

bot.launch()
// Enable graceful stop
process.once('SIGINT', () => bot.stop('SIGINT'))
process.once('SIGTERM', () => bot.stop('SIGTERM'))