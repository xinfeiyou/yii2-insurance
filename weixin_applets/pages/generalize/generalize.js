// pages/generalize/generalize.js
const app = getApp();
Page({

  /**
   * 页面的初始数据
   */
  data: {
    imgSrc:"/img/20180115154413.png"
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {

   

  },

  /**
   * 生命周期函数--监听页面初次渲染完成
   */
  onReady: function (e) {
    let tuiguan = wx.getStorageSync("tuiguan");
    
    if (tuiguan){

      this.setData({
        imgSrc: "http://" + tuiguan
      })

    }else{

      let strUserId = app.strUserId();

      let data = {

        strUserId: strUserId,

        url: "https://api.weixin.qq.com/wxa/getwxacodeunlimit",

        data: '{"scene":"' + strUserId + '","width":430,"path":"pages/index/index"}'

      }
      wx.request({
        url: app.serverUrl + "/yii2-insurance/web/index.php?r=api/user/get-qrcode",
        data: data,
        header: {
          'content-type': "application/x-www-form-urlencoded"
        },
        method: "POST",
        success: (e) => {
          wx.setStorageSync("tuiguan", e.data.data.content.url);
          this.setData({
            imgSrc: "http://" + e.data.data.content.url
          })
        }
      })
    }
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