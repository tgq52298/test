import WxRequest from '../assets/plugins/wx-request/lib/index'

class HttpService extends WxRequest {
	constructor(options) {
		super(options)
		this.$$prefix = ''
		this.$$path = {
			wechatSignUp: '/user/wechat/sign/up',
      wechatSignIn: '/index.php/index/wxapp.login/index.html',
			decryptData : '/user/wechat/decrypt/data',
      signIn: '/index.php/index/wxapp.login/index.html',
      signOut: '/index.php/index/wxapp.login/quit.html',
			banner      : '/banner.html', 
			classify    : '/classify', 
			goods       : '/goods', 
			search      : '/goods/search/all', 
      cart: '/index.php/shop/wxapp.car/add.html',
      cart_change: '/index.php/shop/wxapp.car/change.html',
      showcart: '/index.php/shop/wxapp.car/index.html',
      address: '/member.php/member/wxapp.address/index.html?', 
      order: '/index.php/shop/wxapp.order/add.html', 
        }
        this.interceptors.use({
            request(request) {
            	request.header = request.header || {}
            	request.header['content-type'] = 'application/json'
                if (request.url.indexOf('/api') !== -1 && wx.getStorageSync('token')) {
                    request.header.Authorization = 'Bearer ' + wx.getStorageSync('token')
                }
                wx.showLoading({
                    title: '加载中', 
                })
                return request
            },
            requestError(requestError) {
            	wx.hideLoading()
                return Promise.reject(requestError)
            },
            response(response) {
            	wx.hideLoading()
              /*
            	if(response.statusCode === 401) {
                    wx.removeStorageSync('token')
                    wx.redirectTo({
                        url: '/pages/login/index'
                    })
                }*/
                return response
            },
            responseError(responseError) {
            	wx.hideLoading()
                return Promise.reject(responseError)
            },
        })
	}

	wechatSignUp(params) {
		return this.postRequest(this.$$path.wechatSignUp, {
			data: params,
		})
	}

	wechatSignIn(params) {
		return this.postRequest(this.$$path.wechatSignIn, {
			data: params,
		})
	}

	wechatDecryptData(params) {
		return this.postRequest(this.$$path.decryptData, {
			data: params,
		})
	}
	
	signIn(params) {
		return this.postRequest(this.$$path.signIn, {
			data: params,
		}) 
	}

  signOut(params) {
    return this.postRequest(this.$$path.signOut, {
      data: params,
    }) 
	}

	getBanners(params) {
		return this.getRequest(this.$$path.banner, {
			data: params,
		})
	}

	search(params) {
		return this.getRequest(this.$$path.search, {
			data: params,
		})
	}

	getGoods(params) {
		return this.getRequest(this.$$path.goods, {
			data: params,
		})
	}

	getClassify(params) {
		return this.getRequest(this.$$path.classify, {
			data: params,
		})
	}

	getDetail(id) {
		return this.getRequest(`${this.$$path.goods}/${id}`)
	}

  getCartByUser(goods) {
    return this.getRequest(this.$$path.showcart, {
      data: goods,
    })
	}

	addCartByUser(goods) {
		return this.postRequest(this.$$path.cart, {
      data: goods,
		})
	}

	putCartByUser(id, params) {
    return this.putRequest(`${this.$$path.cart_change}?type=change_num&id=${id}`, {
			data: params,
		})
	}

  delCartByUser(id, params) {
    return this.deleteRequest(`${this.$$path.cart_change}?type=del&id=${id}`, {
      data: params,
    })
	}

  clearCartByUser(params) {
    return this.postRequest(`${this.$$path.cart_change}?type=clear`, {
      data: params,
    })
	}

	getAddressList(params) {
		return this.getRequest(this.$$path.address, {
			data: params,
		})
	}

  getAddressDetail(id, params) {
    return this.getRequest(`${this.$$path.address}?id=${id}`, {
      data: params,
    })
	}

	postAddress(params) {
		return this.postRequest(this.$$path.address, params)
	}

	putAddress(id, params) {
		return this.putRequest(`${this.$$path.address}?add=/${id}`, {
			data: params,
		})
	}

	deleteAddress(id, params) {
		return this.deleteRequest(`${this.$$path.address}?type=/${id}`)
	}

  getDefalutAddress(params) {
    return this.getRequest(`${this.$$path.address}`, {
      data: params,
    })
	}

	setDefalutAddress(id) {
		return this.postRequest(`${this.$$path.address}?type=default/${id}`)
	}

	getOrderList(params) {
		return this.getRequest(this.$$path.order, {
			data: params,
		})
	}

	getOrderDetail(id) {
		return this.getRequest(`${this.$$path.order}/${id}`)
	}

	postOrder(params) {
		return this.postRequest(this.$$path.order, {
			data: params,
		})
	}

	putOrder(id, params) {
		return this.putRequest(`${this.$$path.order}/${id}`, {
			data: params,
		})
	}

	deleteOrder(id, params) {
		return this.deleteRequest(`${this.$$path.order}/${id}`)
	}
}

export default HttpService