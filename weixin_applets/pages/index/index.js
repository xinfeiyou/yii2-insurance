//index.js
//获取应用实例
const app = getApp();
Page({
  data: {
    "imgUrls": ['/img/banner1.png',
      '/img/banner2.png'],
    "title":[
      {
        "type": "text",
        "style": "",
        "content": "个人信息",
        "compId": "data.title[0]",
      },
      {
        "type": "text",
        "style": "",
        "content": "车辆信息",
        "compId": "data.title[1]",
      }
    ],
    form: {
      "type": "form", //表单 
      "compId": "form1", //表单备注
      "eventParams": "{\"inner_page_link\":\"\\/pages\\/choose1\\/choose1\",\"is_redirect\":0}",
      "content":[
        //姓名
        {
          "id":"0",
          "title":"姓名",
          "placeholder":"必填",
          "field":"strRealName"
        },
        {
          "id": "1",
          "title": "手机号码",
          "placeholder": "必填",
          "field":"strPhone"
        },
        {
          "id": "2",
          "title": "行驶城市",
          "value": ['', '', ''],
          "field":"strTravelAdder",
          "bindchange":"bindchange"
        },
        {
          "id": "3",
          "title": "车牌号",
          "content":"未上牌",
          "style":"primary",
          "placeholder":"填写车牌号",
          "value":"",
          "previewImage":"previewImage",
          "field":"strCarNumber",
          "imageList": []
        },
        {
          "content":"下一步",
          "type":"submit",
          "style":"primary"
        }
      ]
    }
  },
  submitForm:function(e){
    let data = e.detail.value;
    for(var i in data){
      if(data[i]==""){
        app.alert({
          type:3,
          argument:{
            title:"警告！",
            content:"请填写相关内容",
            showCancel:false
          }
        })
        return
      }
    }

    let url = app.workUserdata;
    data.strUserId = app.strUserId();
    console.log(data);
    wx.request({
      url: url,
      data:data,
      method:"POST",
      header: {
        'content-type': "application/x-www-form-urlencoded"
      },
      success:(data)=>{
        if (data.data.ret == "0000") {
          wx.setStorageSync("strWorkNum", data.data.data.content);
          app.tapInnerLinkHandler(e);
        } else {
          app.alert({
            type: 1,
            argument: {
              image: '/img/terror.png',
              title: data.data.msg,
            }
          })
        }
      }
    })


  },
  bindchange:function(e){
    app.bindchange(e,this);
  },
  uploadFile:function(e){
    app.uploadFile(e,this)
  },
  buttonEvent:function(e){
    this.setData({
      "form.content[3].value":"未上牌"
    })
  },
  onLoad:function(e){
    var strUserId = app.strUserId();
    if (!strUserId){
      app.turnToPage("/pages/bind/bind");
      return;
    }
    app.login();
    wx.getLocation({
      success: (res)=>{
        wx.request({
          url: `http://apis.map.qq.com/ws/geocoder/v1/?location=${res.latitude},${res.longitude}&key=${app.key}`,
          success:  (e)=>{
           this.setData({
             "form.content[2].value[0]": e.data.result.address_component.province,
             "form.content[2].value[1]": e.data.result.address_component.city,
             "form.content[2].value[2]": e.data.result.address_component.district,
           })
          }
        })
      },
    })
  },

  onReady:function(e){
    let strWorkNum = wx.getStorageSync("strWorkNum");
    if (strWorkNum){
      let url = app.getPage;
      wx.request({
        url: url,
        header: {
          'content-type': "application/x-www-form-urlencoded"
        },
        method: "POST",
        data: { strWorkNum: strWorkNum},
        success: (e)=>{
          let page = e.data.data.content.key;
          app.alert({
            type: 3,
            argument: {
              title: "系统提示",
              content: "您有未完成的表单，是否继续",
              cancelText: "重新填写",
              confirmText: "继续填写",
              success: (res) => {
                if (res.confirm) {
                  switch (page) {
                    case "work_chooseinsurancetype":
                      app.turnToPage("/pages/choose1/choose1");
                      break;
                    case "work_chooseinsurancecompany":
                      app.turnToPage("/pages/choose2/choose2");
                      break;
                    case "work_submitmaterial":
                      app.turnToPage("/pages/choose3/choose3");
                      break;
                    default:
                      break;
                  } 
                } else if (res.cancel) {
                  wx.removeStorageSync("strWorkNum");
                  app.turnToPage("/pages/index/index");
                }
              }
            }
          })
        }
      })
    }
  }
})
