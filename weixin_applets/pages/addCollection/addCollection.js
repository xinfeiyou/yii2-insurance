// pages/repayDetail/repayDetail.js
const app = getApp();
Page({

  /**
   * 页面的初始数据
   */
  data: {
    "listid": "",
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
            "style": true
          },
          {
            "title": "实还日期",
            "value": "2018-10-10",
            "style": true
          },
          {
            "title": "拖欠本金",
            "value": "500元",
            "style": true
          },
          {
            "title": "拖欠利息",
            "value": "13元",
            "style": true
          }
        ]
      }
    },
    form: {
      "type": "form", //表单 
      "compId": "form2", //表单备注
      "submitForm": "submitForm",
      "content": [
        {
          "id": "0",
          "title": "催收方式（必填）",
          "field": "franchise",
          "mode": "selector",
          "value": "0",
          "range": ['投保', "不投保"],
          "bindchange": "bindchange",
        },
        {
          "id": "1",
          "title": "催收人员（必填）",
          "mode": "date",
          "value": "1990-09-05",
          "start": "2000-10-01",
          "end": "2010-08-20",
          "bindchange": "bindchange",
          "field": "businessStart"
        },
        {
          "id": "2",
          "title": "催收时间（必填）",
          "mode": "date",
          "value": "1990-09-05",
          "start": "2000-10-01",
          "end": "2010-08-20",
          "bindchange": "bindchange",
          "field": "businessStart"
        },
        {
          "id":"3",
          "title":"催收结果（必填）",
          "value":"",
          "bindblur":"bindchange",
          "field":"result"
        },
        {
          "id": "4",
          "content": "下一步",
          "type": "submit",
          "style": "primary"
        }
      ]
    }
  },
  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    this.setData({
      listid: options.listid
    })
  },
  eventHandler: function (e) {
    app.tapInnerLinkHandler(e);
  },
  submitForm:function(e){
    let textVal = this.data.form.content[2].value;
    if(textVal.length==0){
      app.alert({
        type: 3,
        argument: {
          title: "警告！",
          content: "请填写相关内容",
          showCancel: false
        }
      })
      return
    }
    app.addCollection(e);
  },
  bindchange: function (e) {
    app.bindchange(e, this);
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