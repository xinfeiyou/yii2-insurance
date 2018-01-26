// pages/idImg/idImg.js
const app = getApp();
Page({

  /**
   * 页面的初始数据
   */
  data: {
      "listid":"",
      "idImg":[
        // {
        //   "name":"身份证",
        //   "list":[
        //     {
        //       "imgSrc": "/img/idcar.png",
        //     },
        //     {
        //       "imgSrc": "/img/idcar_1.png",
        //     }
        //   ]
        // },
        // {
        //   "name":"行驶证",
        //   "list":[
        //     {
        //       "imgSrc":"/img/cars.png",
        //     }
        //   ]
        // },
        // {
        //   "name":"其他证件",
        //   "list":[
        //     {
        //       "imgSrc":"/img/camera.png",
        //     }
        //   ]
        // }
      ]
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    // this.setData({
    //   listid: options.listid
    // })
    let data = {
      oddNumber: options.listid //app.strUserId()
    }
    wx.request({
      url: app.idImg,
      data: data,
      method: "POST",
      header: {
        'content-type': "application/x-www-form-urlencoded"
      },
      success: (e) => {
        console.log(e);
        this.setData({
          "idImg": e.data.data.content
        })
      }
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