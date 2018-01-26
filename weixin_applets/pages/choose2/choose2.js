// pages/choose2/choose2.js
const app = getApp();
Page({

  /**
   * 页面的初始数据
   */
  data: {
    "title": [
      {
        "type": "text",
        "style": "border:none;background-color:#199ed8;text-align:center;line-height:28px;color:#fff;font-size;34rpx;",
        "content": "请选择保险公司",
        "compId": "data.title[0]",
      }
    ],
    form: {
      "type": "form", //表单 
      "compId": "form3", //表单备注
      "eventParams": "{\"inner_page_link\":\"\\/pages\\/choose3\\/choose3\",\"is_redirect\":1}",
      "content": [
        {
          "id":"0",
          "title": "中国人寿",
          "imageSrc":"/img/renshou.png",
          "field":"intChinaLife",
          "checked":true
        },
        {
          "id":"1",
          "title": "中国平安",
          "imageSrc": "/img/pingan.png",
          "field":"intPingan",
          "checked": false
        },
        {
          "id":"2",
          "title": "太平洋保险",
          "imageSrc": "/img/taipingy.png",
          "field":"intCpic",
          "checked": false
        },
        {
          "id":"3",
          "title": "中国大地保险",
          "imageSrc": "/img/picc.png",
          "field": "intChinaContinentInsurancr",
          "checked": false
        }
      ],
      "submit": {
        "content": "下一步",
        "type": "submit",
        "style": "primary"
      }
    },
    bindchange:"bindchange",
    value:"intChinaLife",
  },
  submitForm: function (e) {
    let url = app.chooseinsurancecompany;
    let strWorkNum = wx.getStorageSync("strWorkNum");
    e.detail.value.strWorkNum = strWorkNum;

    app.submitForm(e, url,function(data){
      if(data.data.ret=="0000"){
        app.tapInnerLinkHandler(e);
      }else{
        app.alert({
          type: 1,
          argument: {
            image: '/img/terror.png',
            title: data.data.msg,
          }
        })
      }
    });
  },
  bindchange:function(e){
    let data = e.detail.value;
    this.setData({
      value:data
    })    
  },
  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
  
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