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
      // "fOffLineTotal":"200000",      
      // "intPeriod":"24",
      // "list":[
      //     {
      //       "title": "第一期",
      //       "list":[
      //         {
      //           "title":"还款利息",
      //           "value": "162",
      //           "style": true
      //         },
      //         {
      //           "title": "还款本金",
      //           "value": "162",
      //           "style": true
      //         },
      //         {
      //           "title": "还款时间",
      //           "value": "2018-10-20",
      //           "style": true
      //         },
      //         {
      //           "title": "还款xx",
      //           "value": "162",
      //           "style": true
      //         }
      //       ]
      //     }
      //   ]
      },

      "eventHandler":"eventHandler",
      "eventParams": "{\"inner_page_link\":\"\\/pages\\/idImg\\/idImg\",\"is_redirect\":0}",
      "listid": ""
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
      url: app.repayDetail,
      data: data,
      method: "POST",
      header: {
        'content-type': "application/x-www-form-urlencoded"
      },
      success: (e) => {
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