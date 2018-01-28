//app.js
const serverUrl = "http://192.168.1.38";

//图片文件提交地址
const uploadFileUrl = `${serverUrl}/yii2-insurance/web/index.php?r=api/work/work-user-image`; 
App({
  //弹窗组件
  alert:function(e){
    switch(e.type){
      case 1:
        wx.showToast(e.argument)
        break;
      case 2:
        wx.showLoading(e.argument)
        break;
      case 3:
        wx.showModal(e.argument)
        break;
      default:
        console.log(e.argument.msg);
        break
    }
  },
  //服务器地址
  serverUrl:"http://192.168.1.38",
  key: "GUGBZ-VLRC3-R2N3V-YXBTW-VWKA2-QXBYH",
   // 第一张表单
  workUserdata: serverUrl + "/yii2-insurance/web/index.php?r=api/work/work-user-data",
  // 第二张表单
  chooseinsurancetype: serverUrl + "/yii2-insurance/web/index.php?r=api/work/work-insurance-data",
  // 第三张表单
  chooseinsurancecompany: serverUrl + "/yii2-insurance/web/index.php?r=api/work/work-office-data",
  // 第四张表单
  submitmaterial: serverUrl + "/yii2-insurance/web/index.php?r=api/work/work-user-card",
  // 绑定
  bind: serverUrl + "/yii2-insurance/web/index.php?r=api/user/bind",

  getPage: serverUrl +"/yii2-insurance/web/index.php?r=api/work/work-get-page",

  market: serverUrl + "/yii2-insurance/web/index.php?r=api/user/get-promoter",

  marketHistory: serverUrl + "/yii2-insurance/web/index.php?r=api/work/work-promoter-odd-list",

  repayHistory: serverUrl + "/yii2-insurance/web/index.php?r=api/work/work-user-odd-list",

  //车险详情
  repayDetail: serverUrl + "/yii2-insurance/web/index.php?r=api/work/work-user-odd-replay",

  workDetail: serverUrl + "/yii2-insurance/web/index.php?r=api/work/work-user-odd-apply",

  idImg: serverUrl + "/yii2-insurance/web/index.php?r=api/work/work-user-odd-idimg",

  userInfo: serverUrl + "/yii2-insurance/web/index.php?r=api/user/get-user-info",

  //userId
  strUserId:function(){
    return wx.getStorageSync("strUserId");
  },
  //分析链接组件
  tapInnerLinkHandler: function (event) {
    var param = event.currentTarget.dataset.eventParams;
    let listid = event.currentTarget.dataset.listid;

    param = JSON.parse(param);
    var url
    if (listid){
      url = `${param.inner_page_link}?listid=${listid}`;
    }else{
      url =param.inner_page_link;
    }
    var is_redirect = param.is_redirect 
    this.turnToPage(url, is_redirect);
  },
  // 分析当前的路径 
  turnToPage: function (url, isRedirect) {
    // 判断如果isRedirect 携带的参数的false  的时候保留单前页面打开新的页面
    if (isRedirect == 0) {
      wx.navigateTo({
        url: url
      });
    } else if (isRedirect == 1) {
      //否则打开新的页面
      wx.redirectTo({
        url: url
      })
    } else if (isRedirect == 2) {
      wx.navigateBack({
        delta: 1
      })
    } else {
      wx.reLaunch({
        url: url
      })
    }
  },
  //表单提交
  submitForm:function(e,url,callback){
    let data = e.detail.value;

    wx.request({
      url: url,
      header:{
        'content-type': "application/x-www-form-urlencoded"
      },
      method:"POST",
      data:data,
      success:function(e){
        callback(e)
      }
    })
  },
  //addCollection
  addCollection:function(e){
    let data = e.detail.value;
    wx.request({
      url: formUploadUrl,
      method: "POST",
      data: data,
      success:  (e)=>{
        this.alert({
          type:3,
          argument: {
            title: "系统提示",
            content:"提交成功",
            showCancel:false,
            success:(e)=>{

              this.turnToPage("/pages/about/about")
            }
          }
        })
      }
    })
  },
  //文件上传
  uploadFile: function (arr, that, name, strWorkNum,callback){
    wx.uploadFile({
      url: uploadFileUrl,
      filePath: arr[0],
      formData:{
        "name":name,
        "strWorkNum": strWorkNum
      },
      header: {
        'content-type': "multipart/form-data"
      },
      name:"file",
      dataType:"JSON",
      success: (e) => {
        callback(e);
      }
    })
  },
  //同步页面数据
  bindchange:function(e,that){
    let id = e.target.dataset.id;
    let value = e.detail.value;
    let key = "form.content["+id+"].value";
    that.setData({
      [key]: value
    })
  },
  login: function (that) {
    let openid = wx.getStorageSync("openid");

    if (openid){

    }else{
      wx.login({
        success:(data)=>{
          wx.getUserInfo({
            success:  (e)=>{
              let datas = e.userInfo;

              for(let i in datas){
                wx.setStorage({
                  key:i,
                  data:datas[i],
                })
              }
              
              datas.code = data.code;
              datas.strUserId = this.strUserId();
              wx.request({
                url: serverUrl + "/yii2-insurance/web/index.php?r=api/user/check-login",
                header: {
                  'content-type': "application/x-www-form-urlencoded"
                },
                method: "POST",
                data: datas,
                success: function (e) {
                  let ret = e.data.ret;
                  if(ret="0000"){
                    wx.setStorage({
                      key: "openid",
                      data: e.data.data.content.strOpenId
                    })
                  }
                }
              })
            }
          })
        }
      })
    }
  },
 
})