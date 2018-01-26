// pages/bind/bind.js
const app =getApp();
Page({

  /**
   * 页面的初始数据
   */
  data: {
    btn:"获取验证码",
    disabled:false,
    submitForm:"submitForm"
  },
  getMs:function(e){
    this.setData({
      btn:"60s",
      disabled:true
    })
    var t = 59;
    var timer = setInterval(()=>{
      if (t == 0) {
        clearInterval(timer);
        this.setData({
          btn: '重新获取',
          disabled:false
        })
        return;
      }
      this.setData({
        btn: `${t}s`
      })
      t--;
    },1000)
  },
  submitForm:function(e){
   let data = e.detail.value;
    if(data.phone==""){
      app.alert({
        type: 1,
        argument: {
          image: '/img/terror.png',
          title: '请填写手机号',
        }
      })
      return
    };
    // if(data.password==""){
    //   app.alert({
    //     type: 1,
    //     argument: {
    //       image: '/img/terror.png',
    //       title: '请输入密码',
    //     }
    //   })
    //   return 
    // };
    if(data.code==""){
      app.alert({
        type: 1,
        argument: {
          image: '/img/terror.png',
          title: '请填写验证码',
        }
      })
      return
    };
    var scene = wx.getStorageSync("scene");
    if (scene) {
      data.scene = scene;
    }
//    return;
    wx.request({
      url: app.bind,
      header: {
        'content-type': "application/x-www-form-urlencoded"
      },
      data:data,
      method:"POST",
      success:function(e){
        console.log(e);
        if(e.data.ret=="0000"){
          console.log(e.data.data.content);
          wx.setStorageSync("strUserId", e.data.data.content)
          app.turnToPage("/pages/index/index");
        }else{
          app.alert({
            type: 1,
            argument: {
              image: '/img/terror.png',
              title: e.data.msg
            }
          })
        }
      }
    })

  },
  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    var scene = decodeURIComponent(options.scene);
    wx.setStorageSync("scene", scene);
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