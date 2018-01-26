// pages/repayDetail/repayDetail.js
const app = getApp();
Page({

  /**
   * 页面的初始数据
   */
  data: {
    "listDetail": {
      "user_src": "/img/car.png",
      "name": "客户",
      "phone": "18959333600",
      "car": {
        "title": "逾期记录",
        "list": [
          {
            "title": "逾期期数",
            "value": "3期",
            "style": false
          },
          {
            "title": "实还日期",
            "value": "2018-10-10",
            "style": false
          },
          {
            "title": "拖欠本金",
            "value": "500元",
            "style": false
          },
          {
            "title": "拖欠利息",
            "value": "13元",
            "style": false
          }
        ]
      },
      "insurance": {
        "title": "催收记录1",
        "list": [
          {
            "title": "催收方式",
            "value": "上门",
            "style": false
          },
          {
            "title": "催收人员",
            "value": "催收员A",
            "style": false
          },
          {
            "title": "催收时间",
            "value": "2018-01-05",
            "style": false
          },
          {
            "title": "催收结果",
            "value": "客户答应下午3点前还款",
            "style": false
          }
        ]
      },
      "business": {
        "title": "催收记录2",
        "list": [
          {
            "title": "催收方式",
            "value": "电话",
            "style": false
          },
          {
            "title": "催收人员",
            "value": "催收员D",
            "style": false
          },
          {
            "title": "催收时间",
            "value": "2018-02-05",
            "style": false
          },
          {
            "title": "催收结果",
            "value": "客户答应下午3点前还款",
            "style": false
          }
        ]
      },
      "eventHandler": "eventHandler",
      "eventParams": "{\"inner_page_link\":\"\\/pages\\/addCollection\\/addCollection\",\"is_redirect\":0}",
      "listid": ""
    }
  },
  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    this.setData({
      "listDetail.listid": options.listid
    })
  },
  eventHandler: function (e) {
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