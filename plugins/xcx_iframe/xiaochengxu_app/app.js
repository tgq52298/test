import WxValidate from './assets/plugins/wx-validate/WxValidate'
import WxService from './assets/plugins/wx-service/WxService'
import HttpResource from './helpers/HttpResource'
import HttpService from './helpers/HttpService'
import __config from './config'

App({
	onLaunch() {
		console.log('onLaunch')
	},
	onShow() {
		console.log('onShow')
	},
	onHide() {
		console.log('onHide')
	},
  getLiveUserInfo(){
    let url = this.HttpResource('/index.php/index/wxapp.login/check.html');
    return url.queryAsync({ token: this.getToken() })
      .then(res => {
        const data = res.data
        console.log('user---异步调用---info',data)
        if (data.meta.code == 0) {
          return data.data.userInfo;
        }else{
          this.WxService.removeStorageSync('token');
          this.WxService.removeStorageSync('user')
        }
      })
  },
	getUserInfo(liveData) {
    let info = null;
    if (liveData==true){  //异步获取服务器的用户资料
      info = this.getLiveUserInfo();
    }else{  //用户的缓存资料
      info = this.WxService.getStorageSync('user');
    }    
    this.globalData.userInfo = info;
    return info;
    
		// return this.WxService.login()
		// .then(data => {
    //         console.log(data)
		// 	return this.WxService.getUserInfo()
		// })
		// .then(data => {
    //         console.log(data)
		// 	this.globalData.userInfo = data.userInfo
		// 	return this.globalData.userInfo
		// })
	},

  checkLogin(url) {
    this.getUserInfo(true).then(info => {
      if (info) {
        return info;
      } else {
        this.WxService.redirectTo('/pages/login/index?url=' + escape(url));
      }
    });
    // const token = App.getToken();
    // if (token){
    //   this.setData({
    //     token: token
    //   })
    // }else{
    //   App.WxService.redirectTo('/pages/login/index')
    // }
  },


	globalData: {
		userInfo: null
	},
  getToken(){
    return this.WxService.getStorageSync('token');
  },
	renderImage(path) {
        if (!path) return ''
        if (path.indexOf('http') !== -1) return path
        return `${this.__config.domain}${path}`
    },
	WxValidate: (rules, messages) => new WxValidate(rules, messages), 
	HttpResource: (url, paramDefaults, actions, options) => new HttpResource(url, paramDefaults, actions, options).init(), 
	HttpService: new HttpService({
		baseURL: __config.basePath,
	}), 
	WxService: new WxService, 
	__config, 
})