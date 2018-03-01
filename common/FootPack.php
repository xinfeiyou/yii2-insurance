美团
const axios = require('axios')
const querystring = require('querystring')
const randomPhone = require('../random-phone')
const rohr = require('./rohr')
const crypto = require('./crypto')
const randomCookie = require('./random-cookie')
const logger = require('../logger')

const origin = 'https://activity.waimai.meituan.com'

async function request ({url, mobile}) {
  let params
  try {
    params = {
      ...querystring.parse(url.split('?').pop()),
      channelUrlKey: url.match(/\/(?:sharechannelredirect|sharechannel)\/(.*?)\?/).pop()
    }
  } catch (e) {
    throw new Error('美团红包链接不正确')
  }

  const request = axios.create({
    baseURL: origin,
    headers: {
      origin,
      referer: origin,
      'user-agent': 'Mozilla/5.0 (Linux; Android 5.0; SM-G900P Build/LRX21T MicroMessenger) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2564.23 Mobile Safari/537.36'
    },
    transformRequest: [data => querystring.stringify(data)]
  })

  async function post (url, params = {}, config = {}) {
    params._token = rohr.reload(`${url}?${querystring.stringify(params)}`)
    // logger.trace(params)
    const {data} = await request.post(url, params, config)
    data.data = crypto.decrypto(data.data)
    if (typeof data.data === 'string') {
      data.data = JSON.parse(data.data)
    }
    // logger.trace(data)
    return data
  }

  const {data} = await post('/async/coupon/sharechannelredirect', params)
  if (data === false) {
    throw new Error('美团红包链接不正确\n或\n请求美团服务器失败')
  }
  const lucky = ~~data.share_title.match(/第(\d+)个/).pop()
  logger.info(`第 ${lucky} 个是手气最佳红包`)

  return (async function lottery (userPhone2) {
    const res = await (async function grabShareCoupon () {
      const userPhone = userPhone2 || randomPhone(userPhone2)
      logger.info(`使用 ${userPhone} 尝试领取`)
      const res = await post('/coupon/grabShareCoupon', {
        userPhone,
        channelUrlKey: data.channelUrlKey,
        urlKey: params.urlKey,
        dparam: data.dparam,
        originUrl: url,
        baseChannelUrlKey: '',
        uuid: '',
        platform: 11,
        partner: 162,
        riskLevel: 71
      }, {
        headers: {
          cookie: randomCookie(userPhone2)
        }
      })
      // 4201 需要验证码
      // 1006 该号码归属地暂不支持
      // 1 成功
      // 7003 已领过
      // 4000 抢光了
      // 7002 微信 cookie 不正确或失效
      // 7006 今日领取次数达达到上限
      // 4002 你已经抢过这个红包了
      // 4001 已过期（不知道是什么过期，我认为是红包，所以直接抛出了）
      // 4003 没领到（什么鬼）
      logger.info(res.code, res.msg)
      if (res.code === 4001) {
        throw new Error(res.msg)
      }
      if (res.code === 4003) {
        throw new Error('错误 4003\n我们暂时不知道如何处理，换个红包链接再来吧')
      }
      if ([1, 4000, 7003].includes(res.code)) {
        return res
      }
      // 如果本次是用大号领取的，并且报错了，直接抛出
      if (userPhone2 === mobile) {
        throw new Error(res.msg)
      }
      return grabShareCoupon()
    })()
    const length = res.data.wxCoupons.length
    const number = lucky - length
    if (number <= 0) {
      logger.info('手气最佳红包已被领取')
      return res.data.wxCoupons.find(w => w.bestLuck)
    }
    logger.info(`还有 ${number} 个是最佳红包`)
    return lottery(number === 1 ? mobile : null)
  })()
}

module.exports = async params => {
  const res = await request(params)
  logger.info(JSON.stringify(res)) // 很多地方加了 stringify，是为了日志不要换行
  return {message: `手气最佳红包已被领取\n\n手气最佳：${res.nick_name}\n红包金额：${res.coupon_price / 100} 元\n领取时间：${res.dateStr}`}
}

----------------------------------------------------------------------------------------------------------------------------------------------------------
const axios = require('axios')
const querystring = require('querystring')
const cookie = require('./cookie')
const randomPhone = require('../random-phone')
const logger = require('../logger')

const origin = 'https://h5.ele.me'

async function request ({mobile, url} = {}) {
  const query = querystring.parse(url)

  let index = 0
  const request = axios.create({
    baseURL: origin,
    withCredentials: true,
    headers: {
      origin,
      referer: `${origin}/hongbao/`,
      'user-agent': 'Mozilla/5.0 (Linux; Android 6.0; PRO 6 Build/MRA58K; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/53.0.2785.49 Mobile MQQBrowser/6.2 TBS/043221 Safari/537.36 V1_AND_SQ_7.0.0_676_YYB_D QQ/7.0.0.3135 NetType/WIFI WebP/0.3.0 Pixel/1080'
    },
    transformRequest: [(data, headers) => {
      headers['X-Shard'] = `eosid=${parseInt(query.sn, 16)}`
      return JSON.stringify(data)
    }]
  })

  return (async function lottery (phone) {
    const sns = cookie[index]

    if (!query.sn ||
      !query.lucky_number ||
      isNaN(query.lucky_number) ||
      !sns) {
      throw new Error('饿了么红包链接不正确\n或\n请求饿了么服务器失败')
    }

    phone = phone || randomPhone(mobile)
    // 绑定手机号
    await request.put(`/restapi/v1/weixin/${sns.openid}/phone`, {
      sign: sns.eleme_key,
      phone
    })
    logger.info('绑定手机号', phone)

    // 领红包
    // eslint-disable-next-line camelcase
    const {data: {promotion_records = []}} = await request.post(`/restapi/marketing/promotion/weixin/${sns.openid}`, {
      device_id: '',
      group_sn: query.sn,
      hardware_id: '',
      method: 'phone',
      phone,
      platform: query.platform,
      sign: sns.eleme_key,
      track_id: '',
      unionid: 'fuck', // 别问为什么传 fuck，饿了么前端就是这么传的
      weixin_avatar: '',
      weixin_username: ''
    })

    // 计算剩余第几个为最佳红包
    const number = query.lucky_number - promotion_records.length

    if (number <= 0) {
      // 有时候领取成功了，但是没有返回 lucky，再调一次就可以了
      const lucky = promotion_records.find(r => r.is_lucky) || await lottery(phone)
      logger.info('手气最佳红包已被领取', JSON.stringify(lucky))
      return lucky
        ? `红包领取完毕\n\n手气最佳：${lucky.sns_username}\n红包金额：${lucky.amount} 元`
        : '红包被人抢完\n或\n服务器繁忙'
    }

    logger.info(`还要领 ${number} 个红包才是手气最佳`)
    index++

    // 如果这个是最佳红包，换成指定的手机号领取
    return lottery(number === 1 ? mobile : null)
  })()
}

function response (options) {
  return new Promise(async resolve => {
    try {
      resolve({message: await request(options)})
    } catch (e) {
      logger.error(e.message)
      resolve({
        message: e.message,
        status: (e.response || {}).status
      })
    }
  })
}

module.exports = async options => {
  let res = await response(options)
  // 400 重试一次
  if (res.status === 400) {
    res = await response(options)
    // 仍然 400
    if (res.status === 400) {
      res.message = '今日领取红包个数达到上限\n或\n服务器繁忙'
    }
  }
  return res
}
