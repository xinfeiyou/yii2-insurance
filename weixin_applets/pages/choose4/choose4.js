// pages/choose4/choose4.js
const app = getApp();
Page({

  /**
   * 页面的初始数据
   */
  data: {
    "displayBox":{
      "imgSrc":"/img/success.png"
    },
    "callback":{
      "type": "buttom",
      "style": "primary",
      "content":"返回首页",
      "eventParams": "{\"inner_page_link\":\"\\/pages\\/index\\/index\",\"is_redirect\":3}",
      "callback":"callback"
    }
  },
  callback:function(e){
    app.tapInnerLinkHandler(e);
  },
  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    wx.removeStorageSync('strWorkNum')
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