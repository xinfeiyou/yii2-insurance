// pages/about/about.js
var app = getApp();
Page({

  /**
   * 页面的初始数据
   */
  data: {
    "user_center": {
      'user_src': '',
      'name': '',
      "resHistory": "{\"inner_page_link\":\"\\/pages\\/resHistory\\/resHistory\",\"is_redirect\":0}",
      "repayHistory": "{\"inner_page_link\":\"\\/pages\\/repayHistory\\/repayHistory\",\"is_redirect\":0}",
      "repayNearly": "{\"inner_page_link\":\"\\/pages\\/repayNearly\\/repayNearly\",\"is_redirect\":0}",
      "repayLate": "{\"inner_page_link\":\"\\/pages\\/repayLate\\/repayLate\",\"is_redirect\":0}",
      "market": "{\"inner_page_link\":\"\\/pages\\/market\\/market\",\"is_redirect\":0}",
      "generalize": "{\"inner_page_link\":\"\\/pages\\/generalize\\/generalize\",\"is_redirect\":0}",
      "setting": "setting",
      "strUserId": app.strUserId(),
      "isShow":{
        "repayHistory":1,
        "repayNearly":0,
        "repayLate": 0,
        "market": 0,
        "generalize":0,
        "height1": 0,
        "height2":0
      }
    }
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    let data = {
      strUserId:app.strUserId()
    }
    wx.request({
      url: app.userInfo,
      data:data,
      method: "POST",
      header: {
        'content-type': "application/x-www-form-urlencoded"
      },
      success:(e)=>{
        let userInfo = e.data.data.content.strUserType;
        switch(userInfo){
          case "1":
            this.setData({
              "user_center.isShow.repayNearly":1,
              "user_center.isShow.repayLate": 1,
              "user_center.isShow.market": 1,
              "user_center.isShow.generalize": 1,
              "user_center.isShow.height2": 1,
              "user_center.isShow.height1": 1                                                                          
            })
            break;
          case "2":
            this.setData({
              "user_center.isShow.market": 1,
              "user_center.isShow.generalize": 1,
              "user_center.isShow.height2": 1
            })
            break;
          case "3":
            this.setData({
              "user_center.isShow.height1":1
            })
            break;
          default:
            this.setData({
              "user_center.isShow.height1": 0,
              "user_center.isShow.height2": 0
            })
            break;
        }
      }

    })

  },
  setting: function (e) {
    wx.openSetting({
    })
  },
  tapInnerLinkHandler: function (e) {
    app.tapInnerLinkHandler(e);
  },
  /**
   * 生命周期函数--监听页面初次渲染完成
   */
  onReady: function () {
    let avatarUrl = wx.getStorageSync("avatarUrl");
    let nickName = wx.getStorageSync("nickName");

    this.setData({
      "user_center.user_src": avatarUrl,
      "user_center.name": nickName
    })

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