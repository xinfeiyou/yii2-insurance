// pages/choose1/choose1.js
var util = require('../../utils/util.js');  
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
        "content": "交强险（含车船税）",
        "compId": "data.title[0]",
      },
      {
        "type":"text",
        "style":"background-color:#f2f2f2;text-align:center;line-height:28px;border-bottom:none;margin:10px 0;",
        "content":"商业主险"
      },
      {
        "type": "text",
        "style": "background-color:#f2f2f2;text-align:center;line-height:28px;border-bottom:none;margin:10px 0;",
        "content": "商业附加险"
      }
    ],
    form:{
      "type": "form", //表单 
      "compId": "form2", //表单备注
      "eventParams": "{\"inner_page_link\":\"\\/pages\\/choose2\\/choose2\",\"is_redirect\":0}",
      "content":[
        {
          "id":"0",
          "title":"交强险+车船税",
          "field":"strCompulsoryInsurance"
        },
        {
          "id": "1",
          "title": "生效日期",
          "mode": "date",
          "value": "1900-09-01",
          "start": "2000-09-01",
          "end": "2030-09-10",
          "bindchange":"bindchange",
          "field":"tCompulsoryInsuranceEffectiveTime"
        },
        {
          "id": "2",
          "title":"商业险",
          "field":"strCommercialInsurance"
        },
        {
          "id": "3",
          "title":"生效日期",
          "mode":"date",
          "value":"1990-09-05",
          "start":"2000-10-01",
          "end":"2030-08-20",
          "bindchange": "bindchange",
          "field":"tCommercialInsuranceEffectiveTime"
        },
        {
          "id": "4",
          "content":"以上生效日期为保单预计生效日期,我们将尽量满足您的要求，但保单实际生效日期以最终出单日期为准!",
          "style": "color:red;font-size:26rpx;line-height:23px;display:block;margin-top:-1px;border-top:1px solid red;padding:22rpx 34rpx;text-indent:0rpx;"
        },
        {
          "id": "5",
          "title":"车辆损失险",
          "field":"strLossInsurance",
          "mode": "selector",
          "value": "0",
          "range": ['投保', "不投保"],
          "bindchange": "bindchange",
        },
        {
          "id": "6",
          "title": "第三责任险",
          "mode": "selector",
          "value": "0",
          "range": ['5万', '10万', '15万', '20万', '30万', '50万', '100万', '150万',"200万"],
          "bindchange": "bindchange",
          "field":"strThirdPartyInsurance"
        },
        {
          "id": "7",
          "title":"全车强盗险",
          "field":"strTheftInsurance",
          "mode": "selector",
          "value": "0",
          "range": ['投保', "不投保"],
          "bindchange": "bindchange",
        },
        {
          "id": "8",
          "title": "司机责任险",
          "mode": "selector",
          "value": "0",
          "range": ['1万/人', '2万/人', '3万/人', '4万/人', '5万/人', '10万/人', '20万/人'],
          "bindchange": "bindchange",
          "field":"strDriverLiabilityInsurance"
        },
        {
          "id": "9",
          "title": "乘客责任险",
          "mode": "selector",
          "value": "0",
          "range": ['1万/人', '2万/人', '3万/人', '4万/人', '5万/人', '8万/人', '10万/人', '20万/人', "30万/人", "40万/人","50万/人"],
          "bindchange": "bindchange",
          "field":"strPassengerLiabilityInsurance"
        },
        {
          "id": "10",
          "title": "玻璃破碎险",
          "mode": "selector",
          "value": "0",
          "range": ["国产","进口"],
          "bindchange": "bindchange",
          "field":"strGlassInsurance"
        },
        {
          "id": "11",
          "title": "自燃损失险",
          "field":"intSelfignitingLossInsurance",
          "mode": "selector",
          "value": "0",
          "range": ['投保', "不投保"],
          "bindchange": "strSelfIgnitionInsurance",
        },
        {
          "id": "12",
          "title": "发动机涉水",
          "field":"strWadingInsurance",
          "mode": "selector",
          "value": "0",
          "range": ['投保', "不投保"],
          "bindchange": "bindchange",
        },
        {
          "id": "13",
          "title": "划痕险",
          "mode": "selector",
          "value": "0",
          "range": ["2000","5000","10000","20000"],
          "bindchange": "bindchange",
          "field":"strScratchInsurance"
        },
        {
          "id": "14",
          "title": "不计免赔率险",
          "field":"strExcessInsurance",
          "mode": "selector",
          "value": "0",
          "range": ['投保', "不投保"],
          "bindchange": "bindchange",
        },
        {
          "id": "15",
          "content": "下一步",
          "type": "submit",
          "style": "primary"
        }
      ]
    }
  },
  submitForm: function (e) {
    let url = app.chooseinsurancetype;
    let strWorkNum = wx.getStorageSync("strWorkNum");
    e.detail.value.strWorkNum = strWorkNum;
    app.submitForm(e,url,function(data){
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
    app.bindchange(e,this);
  },
  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    var time = util.formatTime(new Date());
    this.setData({
      "form.content[1].value": time,
      "form.content[3].value": time
    })
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