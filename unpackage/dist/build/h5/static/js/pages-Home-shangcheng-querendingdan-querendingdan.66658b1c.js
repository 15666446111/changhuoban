(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["pages-Home-shangcheng-querendingdan-querendingdan"],{1063:function(t,i,e){"use strict";var a,n=function(){var t=this,i=t.$createElement,e=t._self._c||i;return e("v-uni-view",{staticClass:"uni-numbox"},[e("v-uni-view",{staticClass:"uni-numbox__minus",class:{"uni-numbox--disabled":t.inputValue<=t.min||t.disabled},on:{click:function(i){arguments[0]=i=t.$handleEvent(i),t._calcValue("minus")}}},[t._v("-")]),e("v-uni-input",{staticClass:"uni-numbox__value",attrs:{disabled:t.disabled,type:"number"},on:{blur:function(i){arguments[0]=i=t.$handleEvent(i),t._onBlur.apply(void 0,arguments)}},model:{value:t.inputValue,callback:function(i){t.inputValue=i},expression:"inputValue"}}),e("v-uni-view",{staticClass:"uni-numbox__plus",class:{"uni-numbox--disabled":t.inputValue>=t.max||t.disabled},on:{click:function(i){arguments[0]=i=t.$handleEvent(i),t._calcValue("plus")}}},[t._v("+")])],1)},o=[];e.d(i,"b",(function(){return n})),e.d(i,"c",(function(){return o})),e.d(i,"a",(function(){return a}))},"207f":function(t,i,e){var a=e("24fb");i=a(!1),i.push([t.i,'.body[data-v-34177f52]{overflow:hidden;margin-top:1%}.ckeck[data-v-34177f52]{margin-left:20%;font-size:%?28?%;margin-top:3%}.pay[data-v-34177f52]{width:100%;background-color:#fff;height:%?100?%;display:-webkit-box;display:-webkit-flex;display:flex}.pay-view[data-v-34177f52]{width:60%;display:-webkit-box;display:-webkit-flex;display:flex}.pay-img[data-v-34177f52]{width:%?50?%;height:%?50?%;margin-top:%?20?%;margin-left:%?20?%}.pay-text[data-v-34177f52]{margin-top:%?25?%;margin-left:%?10?%}#ckeck[data-v-34177f52]{margin-left:%?400?%;margin-top:%?20?%}\r\n/* 提交栏 */.pos[data-v-34177f52]{width:100%;height:6%;position:fixed;bottom:0;background-color:#ff8c00}.pos-text[data-v-34177f52]{text-align:center;margin-top:%?20?%;color:#fff}.xixian[data-v-34177f52]{width:96%;height:%?1?%;margin-left:2%;background-color:#f1f1f1}.xian[data-v-34177f52]{width:100%;height:%?25?%;background-color:#f1f1f1}.header[data-v-34177f52]{display:-webkit-box;display:-webkit-flex;display:flex;margin-left:%?20?%;width:80%}.header-text[data-v-34177f52]{height:%?80?%;line-height:%?80?%;font-size:%?28?%;font-weight:600;margin-left:%?6?%}.header-img[data-v-34177f52]{margin-top:1.5%}uni-page-body[data-v-34177f52]{background-color:#fff}.addressBar[data-v-34177f52]{margin-top:%?20?%}.addressBar-name[data-v-34177f52]{margin-left:%?50?%;margin-top:%?20?%;font-size:%?33?%;font-weight:600}.addressBar-image[data-v-34177f52]{width:%?40?%;height:%?40?%;position:absolute;right:%?40?%}.d-flex[data-v-34177f52]{margin-left:%?40?%;font-size:%?30?%;margin-top:%?5?%}.caution[data-v-34177f52]{color:red;width:90%;margin-left:5%}.label[data-v-34177f52]{border:1px solid #007bff;height:%?38?%;line-height:%?38?%;color:#007bff;width:%?80?%;text-align:center}.site[data-v-34177f52]{height:%?40?%;line-height:%?40?%;margin-left:%?10?%;width:76%;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}\r\n/* 分割线 */.hr[data-v-34177f52]{width:100%;height:1px;display:block;position:relative;margin-top:3%}.hr[data-v-34177f52]:after,\r\n.hr[data-v-34177f52]:before{content:"";position:absolute;width:100%;height:5px;bottom:0;left:0}.hr[data-v-34177f52]:after{-webkit-transition:opacity .3s ease,animation .3s ease;-webkit-transition:opacity .3s ease,-webkit-animation .3s ease;transition:opacity .3s ease,-webkit-animation .3s ease;transition:opacity .3s ease,animation .3s ease;transition:opacity .3s ease,animation .3s ease,-webkit-animation .3s ease;background:-webkit-linear-gradient(left,#62efab 5%,#f2ea7d 15%,#f2ea7d 25%,#ff8797 35%,#ff8797 45%,#e1a4f4 55%,#e1a4f4 65%,#82fff4 75%,#82fff4 85%,#62efab 95%);background:linear-gradient(90deg,#62efab 5%,#f2ea7d 15%,#f2ea7d 25%,#ff8797 35%,#ff8797 45%,#e1a4f4 55%,#e1a4f4 65%,#82fff4 75%,#82fff4 85%,#62efab 95%);background-size:200%;background-position:0;-webkit-animation:bar 15s linear infinite;animation:bar 15s linear infinite}\r\n/* 内容 */.information[data-v-34177f52]{width:100%;display:-webkit-box;display:-webkit-flex;display:flex;height:%?240?%}.information-img[data-v-34177f52]{width:30%;margin-left:%?30?%;margin-top:%?17?%}.information-view[data-v-34177f52]{margin-left:%?40?%;margin-top:%?50?%}.information-text[data-v-34177f52]{font-size:%?28?%}.information-figure[data-v-34177f52]{margin-top:%?60?%;font-size:%?30?%;color:red}\r\n/*增加框*/.amount[data-v-34177f52]{display:-webkit-box;display:-webkit-flex;display:flex;margin-left:%?210?%;background-color:#c5c3c3;width:%?140?%;height:%?54?%}.minus-input[data-v-34177f52]{width:%?60?%;text-align:center;background-color:#fff;margin-top:%?2?%;height:%?50?%}.amount-add[data-v-34177f52]{width:%?40?%;text-align:center;margin-top:%?5?%}\r\n/*合计*/.total[data-v-34177f52]{width:100%;height:%?80?%;position:relative}.total-text[data-v-34177f52]{position:absolute;right:%?40?%;top:%?15?%;font-size:%?28?%;color:red}.mall-xian[data-v-34177f52]{width:98%;height:1px;margin-left:1%;border-bottom:1px dashed #c5c3c3;margin-top:%?20?%}.pos[data-v-34177f52]{width:100%;height:%?80?%;position:fixed;bottom:0;background-color:#f1f1f1;display:-webkit-box;display:-webkit-flex;display:flex}.pos-text[data-v-34177f52]{color:red;font-size:%?28?%;margin-top:%?20?%;width:30%}.post[data-v-34177f52]{margin-left:%?20?%;margin-top:%?18?%;font-size:%?28?%;width:20%}.pos-Text[data-v-34177f52]{margin-top:%?20?%}.pos-view1[data-v-34177f52]{width:25%;font-size:%?28?%;color:#fff;background-color:red;text-align:center;margin-left:%?290?%}body.?%PAGE?%[data-v-34177f52]{background-color:#fff}',""]),t.exports=i},"33ae":function(t,i,e){"use strict";var a=e("ee27");Object.defineProperty(i,"__esModule",{value:!0}),i.default=void 0;var n=a(e("4eb4")),o=a(e("d1d1")),s={components:{uniNumberBox:n.default},data:function(){return{productInfo:{},num:1,moneyTotal:"",address:[],pagesShow:!1,radio:function(t){this.pay_type=t}}},onLoad:function(t){t.num&&(this.num=t.num),this.getProductInfo(t.product),this.getDeAddress()},methods:{getProductInfo:function(t){var i=this;(0,o.default)({url:"/V1/getproductinfo",method:"get",data:{product:t},success:function(t){i.productInfo=t.data.success.data,i.moneyTotal=i.productInfo.price*i.num}})},getDeAddress:function(){var t=this;(0,o.default)({url:"/V1/getDefaultAddress",method:"get",success:function(i){t.pagesShow=!0,i.data.success&&(t.address=i.data.success.data)}})},addOrderCreate:function(){var t=this;return this.pay_type?""==this.address?(uni.showToast({title:"请选择收货地址",icon:"none"}),!1):(uni.showLoading({duration:1e4,mask:!0}),void(0,o.default)({url:"/V1/addOrderCreate",method:"POST",data:{product_id:this.productInfo.id,product_price:this.productInfo.price,numbers:this.num,price:this.moneyTotal,address:address,pay_type:this.pay_type},success:function(i){uni.hideLoading(),i.data.success?"1"==t.pay_type?uni.requestPayment({provider:"alipay",orderInfo:i.data.success.data.sign,success:function(t){console.log("success:"+JSON.stringify(t))},fail:function(t){console.log("fail:"+JSON.stringify(t))}}):uni.requestPayment({provider:"wxpay",orderInfo:i.data.success.data.sign,success:function(t){console.log("success:"+JSON.stringify(t))},fail:function(t){console.log("fail:"+JSON.stringify(t))}}):uni.showToast({title:i.data.error.message,icon:"none"})}})):(uni.showToast({title:"请选择支付方式",icon:"none"}),!1)}}};i.default=s},"49c9":function(t,i,e){var a=e("207f");"string"===typeof a&&(a=[[t.i,a,""]]),a.locals&&(t.exports=a.locals);var n=e("4f06").default;n("c7e69a32",a,!0,{sourceMap:!1,shadowMode:!1})},"4c11":function(t,i,e){"use strict";var a=e("77b3"),n=e.n(a);n.a},"4eb4":function(t,i,e){"use strict";e.r(i);var a=e("1063"),n=e("7159");for(var o in n)"default"!==o&&function(t){e.d(i,t,(function(){return n[t]}))}(o);e("4c11");var s,r=e("f0c5"),d=Object(r["a"])(n["default"],a["b"],a["c"],!1,null,"569e84ec",null,!1,a["a"],s);i["default"]=d.exports},"58a4":function(t,i,e){"use strict";Object.defineProperty(i,"__esModule",{value:!0}),i.default=void 0;var a="http://livechb3.changhuoban.com/api",n=a;i.default=n},7159:function(t,i,e){"use strict";e.r(i);var a=e("9d2f"),n=e.n(a);for(var o in a)"default"!==o&&function(t){e.d(i,t,(function(){return a[t]}))}(o);i["default"]=n.a},"72d5":function(t,i,e){"use strict";e.r(i);var a=e("b619"),n=e("adef");for(var o in n)"default"!==o&&function(t){e.d(i,t,(function(){return n[t]}))}(o);e("8a69");var s,r=e("f0c5"),d=Object(r["a"])(n["default"],a["b"],a["c"],!1,null,"34177f52",null,!1,a["a"],s);i["default"]=d.exports},"77b3":function(t,i,e){var a=e("bd8a");"string"===typeof a&&(a=[[t.i,a,""]]),a.locals&&(t.exports=a.locals);var n=e("4f06").default;n("d98abdf0",a,!0,{sourceMap:!1,shadowMode:!1})},"8a69":function(t,i,e){"use strict";var a=e("49c9"),n=e.n(a);n.a},"9d2f":function(t,i,e){"use strict";e("a9e3"),e("ac1f"),e("1276"),Object.defineProperty(i,"__esModule",{value:!0}),i.default=void 0;var a={name:"UniNumberBox",props:{value:{type:[Number,String],default:1},min:{type:Number,default:0},max:{type:Number,default:100},step:{type:Number,default:1},disabled:{type:Boolean,default:!1}},data:function(){return{inputValue:0}},watch:{value:function(t){this.inputValue=+t},inputValue:function(t,i){+t!==+i&&this.$emit("change",t)},max:function(t,i){this.inputValue>t&&(this.inputValue=t),0===this.inputValue&&t>0&&(this.inputValue=1)}},created:function(){this.inputValue=+this.value},methods:{_calcValue:function(t){if(!this.disabled){var i=this._getDecimalScale(),e=this.inputValue*i,a=this.step*i;"minus"===t?e-=a:"plus"===t&&(e+=a),e<this.min||e>this.max||(this.inputValue=e/i)}},_getDecimalScale:function(){var t=1;return~~this.step!==this.step&&(t=Math.pow(10,(this.step+"").split(".")[1].length)),t},_onBlur:function(t){var i=t.detail.value;i?(i=+i,i>this.max?i=this.max:i<this.min&&(i=this.min),this.inputValue=i):this.inputValue=0}}};i.default=a},ac59:function(t,i,e){t.exports=e.p+"static/img/zfb.df1de0b0.jpg"},adef:function(t,i,e){"use strict";e.r(i);var a=e("33ae"),n=e.n(a);for(var o in a)"default"!==o&&function(t){e.d(i,t,(function(){return a[t]}))}(o);i["default"]=n.a},b619:function(t,i,e){"use strict";var a,n=function(){var t=this,i=t.$createElement,a=t._self._c||i;return t.pagesShow?a("v-uni-view",[a("v-uni-view",{staticClass:"xian"}),a("v-uni-view",{staticClass:"addressBar"},[""==t.address?a("v-uni-navigator",{attrs:{"hover-class":"none",url:"../dizhi/dizhi?pages=place_order"}},[a("v-uni-view",{staticClass:"addressBar-name"},[t._v("选择收货地址")]),a("v-uni-image",{staticClass:"addressBar-image",attrs:{src:"/static/jiantou.png"}}),a("v-uni-view",{staticClass:"d-flex"},[a("v-uni-view",{staticClass:"site"})],1),a("v-uni-view",{staticClass:"caution"},[a("v-uni-text",{},[t._v("为减少接触，您可以在收货详细地址后增加如小区北门、保安亭、等方便提货的地址")])],1)],1):a("v-uni-navigator",{attrs:{"hover-class":"none",url:"../dizhi/dizhi?pages=place_order"}},[a("v-uni-view",{staticClass:"addressBar-name"},[t._v(t._s(t.address.name)+" "+t._s(t.address.tel))]),a("v-uni-image",{staticClass:"addressBar-image",attrs:{src:"/static/jiantou.png"}}),a("v-uni-view",{staticClass:"d-flex"},[a("v-uni-view",{staticClass:"label"},[t._v("地址")]),a("v-uni-view",{staticClass:"site"},[t._v(t._s(t.address.province)+t._s(t.address.city)+t._s(t.address.area)+t._s(t.address.detail))])],1),a("v-uni-view",{staticClass:"caution"},[a("v-uni-text",{},[t._v("为减少接触，您可以在收货详细地址后增加如小区北门、保安亭、等方便提货的地址")])],1)],1)],1),a("v-uni-view",{staticClass:"hr"}),a("v-uni-radio-group",[a("v-uni-view",[a("v-uni-view",{staticClass:"xian"}),a("v-uni-view",{staticClass:"pay"},[a("v-uni-view",{staticClass:"pay-view"},[a("v-uni-image",{staticClass:"pay-img",attrs:{src:e("ff28"),mode:"widthFix"}}),a("v-uni-view",{staticClass:"pay-text"},[t._v("微信支付")])],1),a("v-uni-view",{staticClass:"ckeck"},[a("v-uni-radio",{staticClass:"radio",attrs:{value:"2",checked:"2"===t.pay_type},on:{click:function(i){arguments[0]=i=t.$handleEvent(i),t.radio("2")}}})],1)],1),a("v-uni-view",{staticClass:"xian"}),a("v-uni-view",{staticClass:"pay"},[a("v-uni-view",{staticClass:"pay-view"},[a("v-uni-image",{staticClass:"pay-img",attrs:{src:e("ac59"),mode:"widthFix"}}),a("v-uni-view",{staticClass:"pay-text"},[t._v("支付宝支付")])],1),a("v-uni-view",{staticClass:"ckeck"},[a("v-uni-radio",{staticClass:"radio",attrs:{color:"#ED6E11",value:"1",checked:"1"===t.pay_type},on:{click:function(i){arguments[0]=i=t.$handleEvent(i),t.radio("1")}}})],1)],1)],1)],1),a("v-uni-view",{staticClass:"pos"},[a("v-uni-view",{staticClass:"post"},[t._v("实付款：")]),a("v-uni-view",{staticClass:"pos-text"},[t._v("¥"+t._s(t.moneyTotal/100))]),a("v-uni-view",{staticClass:"pos-view1"},[a("v-uni-view",{on:{click:function(i){arguments[0]=i=t.$handleEvent(i),t.addOrderCreate.apply(void 0,arguments)}}},[a("v-uni-view",{staticClass:"pos-Text"},[t._v("提交订单")])],1)],1)],1)],1):t._e()},o=[];e.d(i,"b",(function(){return n})),e.d(i,"c",(function(){return o})),e.d(i,"a",(function(){return a}))},bd8a:function(t,i,e){var a=e("24fb");i=a(!1),i.push([t.i,'.uni-numbox[data-v-569e84ec]{display:-webkit-inline-box;display:-webkit-inline-flex;display:inline-flex;-webkit-box-orient:horizontal;-webkit-box-direction:normal;-webkit-flex-direction:row;flex-direction:row;-webkit-box-pack:start;-webkit-justify-content:flex-start;justify-content:flex-start;height:%?70?%;position:relative}.uni-numbox[data-v-569e84ec]:after{content:"";position:absolute;-webkit-transform-origin:center;transform-origin:center;box-sizing:border-box;pointer-events:none;top:-50%;left:-50%;right:-50%;bottom:-50%;border:1px solid #c8c7cc;border-radius:%?12?%;-webkit-transform:scale(.5);transform:scale(.5)}.uni-numbox__minus[data-v-569e84ec],\n.uni-numbox__plus[data-v-569e84ec]{margin:0;background-color:#f8f8f8;width:%?70?%;font-size:%?40?%;height:100%;line-height:%?70?%;text-align:center;display:-webkit-inline-box;display:-webkit-inline-flex;display:inline-flex;-webkit-box-align:center;-webkit-align-items:center;align-items:center;-webkit-box-pack:center;-webkit-justify-content:center;justify-content:center;color:#333;position:relative}.uni-numbox__value[data-v-569e84ec]{position:relative;background-color:#fff;width:%?80?%;height:100%;text-align:center;padding:0}.uni-numbox__value[data-v-569e84ec]:after{content:"";position:absolute;-webkit-transform-origin:center;transform-origin:center;box-sizing:border-box;pointer-events:none;top:-50%;left:-50%;right:-50%;bottom:-50%;border-style:solid;border-color:#c8c7cc;border-left-width:1px;border-right-width:1px;border-top-width:0;border-bottom-width:0;-webkit-transform:scale(.5);transform:scale(.5)}.uni-numbox--disabled[data-v-569e84ec]{color:silver}',""]),t.exports=i},d1d1:function(t,i,e){"use strict";var a=e("ee27");Object.defineProperty(i,"__esModule",{value:!0}),i.default=void 0;var n=a(e("58a4")),o=function(t){t.url=n.default+t.url;try{var i=uni.getStorageSync("token"),e=uni.getStorageSync("operate"),a=uni.getStorageSync("type");if(""==i)return void uni.redirectTo({url:"/pages/index/index"});if(""==e)return void uni.redirectTo({url:"/pages/index/index"});if(""==a)return void uni.redirectTo({url:"/pages/index/index"});uni.request({url:t.url,header:{Authorization:"Bearer "+i},method:t.method,data:t.data,success:function(i){if(200==i.statusCode&&t.success(i),505==i.statusCode)return uni.showToast({title:"登录失效",icon:"none",mask:!0,position:"bottom"}),void setTimeout((function(){uni.redirectTo({url:"/pages/index/index"})}),1e3)}})}catch(o){uni.showToast({title:"系统错误，请联系客服",icon:"none",position:"bottom"})}},s=o;i.default=s},ff28:function(t,i,e){t.exports=e.p+"static/img/wx.0aba8b44.png"}}]);