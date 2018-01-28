// pages/repayDetail/repayDetail.js
const app = getApp();
Page({

  /**
   * 页面的初始数据
   */
  data: {
    "listDetail":{
      // "user_src":"/img/user-face.png",
      // "name":"客户",
      // "phone":"18959333600",
      // "car":{
      //   "title":"车辆信息",
      //   "list":[
      //     {
      //       "title":"行驶城市",
      //       "value":"广东省 深圳市 福田市",
      //       "style": false
      //     },
      //     {
      //       "title":"车牌号码",
      //       "value":"粤A8888",
      //       "style": false
      //     }
      //   ]
      // },
      // "insurance": {
      //   "title": "保险信息",
      //   "list": [
      //     {
      //       "title": "保险公司",
      //       "value": "中国人寿",
      //       "style":false
      //     },
      //     {
      //       "title": "交强险+车船险",
      //       "value": "投保",
      //       "style":false
      //     },
      //     {
      //       "title":"生效时间",
      //       "value":"2017-12-31",
      //       "style": false
      //     },
      //     {
      //       "title":"商业主险",
      //       "value":"投保",
      //       "style": false
      //     },
      //     {
      //       "title":"生效时间",
      //       "value":"2017-12-31",
      //       "style": false
      //     }
      //   ]
      // },
      // "business": {
      //   "title": "商业主险",
      //   "list": [
      //     {
      //       "title": "车辆损失险",
      //       "value": "投保",
      //       "style": false
      //     },
      //     {
      //       "title": "第三责任险",
      //       "value": "5万",
      //       "style": false
      //     },
      //     {
      //       "title":"全车盗抢险",
      //       "value":"投保",
      //       "style": false
      //     },
      //     {
      //       "title":"司机责任险",
      //       "value":"3万/人",
      //       "style": false
      //     },
      //     {
      //       "title":"乘客责任险",
      //       "value":"1万/人",
      //       "style": false
      //     }
      //   ]
      // },
      // "addition": {
      //   "title": "商业附加险",
      //   "list": [
      //     {
      //       "title": "玻璃破碎险",
      //       "value": "进口",
      //       "style": false
      //     },
      //     {
      //       "title": "自燃损失险",
      //       "value": "投保",
      //       "style": false
      //     },
      //     {
      //       "title": "发动机涉水险",
      //       "value": "投保",
      //       "style": false
      //     },
      //     {
      //       "title": "划痕险",
      //       "value": "2000",
      //       "style": false
      //     },
      //     {
      //       "title": "不计免赔率险",
      //       "value": "投保",
      //       "style": false
      //     }
      //   ]
      // },
      // "eventHandler":"eventHandler",
      // "eventParams": "{\"inner_page_link\":\"\\/pages\\/idImg\\/idImg\",\"is_redirect\":0}",
      // "listid": ""
    }
  },
  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    // console.log(options);
    // this.setData({
    //   "listDetail.listid": options.listid
    // })
    let data = {
      oddNumber: options.listid //app.strUserId()
    }
    wx.request({
      url: app.workDetail,
      data: data,
      method: "POST",
      header: {
        'content-type': "application/x-www-form-urlencoded"
      },
      success: (e) => {
        console.log(e);
        this.setData({
          "listDetail": e.data.data.content
        })
      }
    })
  },
  eventHandler:function(e){
    app.tapInnerLinkHandler(e);
  },
  /**
   * 生命周期函数--监听页面初次渲染完成
   */
  onReady: function () {
  
  },

  /**
   * 生命周期函数--监听页面显示
   */
  onShow: function () {
  
  },

  /**
   * 生命周期函数--监听页面隐藏
   */
  onHide: function () {
  
  },

  /**
   * 生命周期函数--监听页面卸载
   */
  onUnload: function () {
  
  },

  /**
   * 页面相关事件处理函数--监听用户下拉动作
   */
  onPullDownRefresh: function () {
  
  },

  /**
   * 页面上拉触底事件的处理函数
   */
  onReachBottom: function () {
  
  },

  /**
   * 用户点击右上角分享
   */
  onShareAppMessage: function () {
  
  }
})