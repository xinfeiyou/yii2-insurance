// pages/repayHistory/repayHistory.js
const app = getApp();
Page({

  /**
   * 页面的初始数据
   */
  data: {
    list:{
      "name":"项目记录",
      "list":[
        {
          "id": "1",
          "faceSrc":"/img/user-face.png",
          "timer": "2017-10-20",
          "money": "2020",
          "user": "客户1",
          "detailsEvent":"detailsEvent",
          "eventParams":"{\"inner_page_link\":\"\\/pages\\/workDetail\\/workDetail\",\"is_redirect\":0}"
        }
      ]
    }
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    let data = {
      strUserId: options.listid //app.strUserId()
    }
    return
    wx.request({
      url: app.resHistory,
      data: data,
      method: "POST",
      header: {
        'content-type': "application/x-www-form-urlencoded"
      },
      success: (e) => {
        this.setData({
          "list.list": e.data.data.content
        })
      }
    })
  },
  detailsEvent:function(e){
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