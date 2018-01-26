// pages/choose3/choose3.js
const app = getApp();
Page({

  /**
   * 页面的初始数据
   */
  data: {
    "formdata":{
      strWorkNum: "",
      strFaceIdCard:[],
      strFaceVehicleLicense:[],
      strReverseIdCard:[],
      strOther:[]
    },
    "title": [
      {
        "type": "text",
        "style": "border:none;background-color:#199ed8;text-align:center;line-height:28px;color:#fff;font-size;34rpx;",
        "content": "提交资料",
        "compId": "data.title[0]",
      }
    ],
    form: {
      "type": "form", //表单 
      "compId": "form4", //表单备注
      "eventParams": "{\"inner_page_link\":\"\\/pages\\/choose4\\/choose4\",\"is_redirect\":1}",
      "content": [
        {
          "id":"0",
          "title": "身份证正面",
          "content": "上传照片",
          "chooseImage": "chooseImage",
          "previewImage": "previewImage",
          "num":1,
          "field": "strFaceIdCard",
          "imageList": []
        },
        {
          "id":"1",
          "title": "身份证反面",
          "content": "上传照片",
          "chooseImage": "chooseImage",
          "previewImage": "previewImage",
          "num": 1,
          "field": "strReverseIdCard",
          "imageList": []
        },
        {
          "id":"2",
          "title": "行驶证正面",
          "content": "上传照片",
          "chooseImage": "chooseImage",
          "previewImage": "previewImage",
          "num": 1,
          "field": "strFaceVehicleLicense",
          "imageList": []
        },
        {
          "id":"3",
          "title": "（非必填）其他",
          "content": "上传照片",
          "chooseImage": "chooseImage",
          "previewImage": "previewImage",
          "num": 9,
          "field": "strOther",
          "imageList": []
        },
        {
          "id":"4",
          "content": "提示：拍照时请务必保证照片清晰度，如果有反光或模糊会影响报价和出单。由于照片传输会受到网络因素影响，有可能需要更多时间，请耐心等待！",
          "style": "color:red;font-size:26rpx;line-height:23px;display:block;margin:0 15px;border-top:1px solid #D9D9D9;padding-top:10px;padding-bottom:10px;text-indent:0rpx;border-bottom:solid #D9D9D9 1px;"
        },
        {
          "id":"5",
          "title": "示例",
          "imageSrc": "/img/idcar.png"
        },
        {
          "id":"6",
          "title": "示例1",
          "imageSrc": "/img/idcar_1.png"
        },
        {
          "id":"7",
          "title": "示例2",
          "imageSrc": "/img/cars.png"
        },
        {
          "id":"8",
          "content": "下一步",
          "type": "submit",
          "style": "primary"
        }
      ]
    }
  },
  submitForm: function (e) {
    
    let data = this.data.formdata;

    let strWorkNum = wx.getStorageSync("strWorkNum");

    data.strWorkNum = strWorkNum;
    if (data.strFaceIdCard=='' || data.strFaceVehicleLicense=='' || data.strReverseIdCard==''){
      app.alert({
        type: 1,
        argument: {
          image: '/img/terror.png',
          title:'请上传相关信息',
        }
      })
      return;
    }

    wx.request({
      url: app.submitmaterial,
      header: {
        'content-type': "application/x-www-form-urlencoded"
      },
      method: "POST",
      data: data,
      success: function (data) {
        if(data.data.ret=="0000"){
          app.tapInnerLinkHandler(e);
        }else{
          app.alert({
            type: 1,
            argument: {
              image:'/img/terror.png',
              title: data.data.msg,
            }
          })
        }
      }
    })

    // app.tapInnerLinkHandler(e);

  },

  chooseImage: function (e) {
    let strWorkNum = this.data.strWorkNum;

    let key = "form.content[" + e.target.dataset.id + "].imageList";

    let name = e.target.dataset.name;

    let arrVal = this.data.form.content[e.target.dataset.id].imageList || [];
    
    let num = e.target.dataset.num;

    var that = this;

    wx.chooseImage({

      sourceType: ['camera'],

      sizeType: ['compressed'],

      count: num,

      success:  (res)=>{

        if(num !="1"){
          if (arrVal.length > 8){
            app.alert({
              type: 1,
              argument: {
                title: "已达上限"
              }
            })
          }else{
            arrVal.push(res.tempFilePaths)
          }
          app.uploadFile(res.tempFilePaths, that, name,strWorkNum,function(e){

            let data = JSON.parse(e.data).data;

            let url = data.content.url;

            let name = data.content.name;

            let formdata = that.data.formdata;

            if (formdata[name].length > 8){

            }else{
              formdata[name].push(url);
            }
            
          });

        }else{

          arrVal[0] = res.tempFilePaths;
          
          app.uploadFile(res.tempFilePaths, that, name,strWorkNum,function(e){

            let datas = JSON.parse(e.data).data;

            let url = datas.content.url;

            let name = datas.content.name;

            let formdata = that.data.formdata;

            formdata[name][0] = url;

          });

        }

        that.setData({

          [key]: arrVal

        })

      }
    })
  },

  /*previewImage: function (e) {
    var current = "formdata."+e.target.dataset.field;

    if (current =="formdata.strOther"){

      var srcIndex = e.target.dataset.srcindex;
     
      var id = e.target.dataset.id;

      var data = "form.content[" + id + "].imageList"

      let newdata = this.data.formdata.strOther.splice(srcIndex,1);

      console.log(newdata)

      this.setData({

        [data]: newdata

      })
      
      return;
      this.data.formdata.strOther.removeByValue(src)

      console.log(this.data.formdata)

      return

    }

    this.setData({
      [current]:[]
    })

    console.log(this.data.formdata)

    var id = e.target.dataset.id;

    var data= "form.content["+id+"].imageList"

    this.setData({

      [data]:[]

    })
  },
*/
  //文件上传
  uploadFile: function (arr, that, key) {
    let strWorkNum = wx.getStorageSync("strWorkNum"); 
    wx.uploadFile({
      url: uploadFileUrl,
      filePath: arr[0],
      formData: {
        "name": key,
        "strWorkNum": strWorkNum
      },
      header: {
        'content-type': "multipart/form-data"
      },
      name: "file",
      dataType: "JSON",
      success: (e) => {
        
      }
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