(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["pages-Home-shangcheng-xinzeng-address_edit"],{1095:function(e,t,a){var i=a("24fb");t=i(!1),t.push([e.i,"uni-page-body[data-v-03f1a8ce]{background-color:#f7f7f7}.indexs[data-v-03f1a8ce]{width:94%;background-color:#fff;margin:0 3%;margin-top:%?20?%;border-radius:%?8?%;overflow:hidden}.selects[data-v-03f1a8ce]{width:100%;position:relative;margin-top:2%}.select-view[data-v-03f1a8ce]{display:-webkit-box;display:-webkit-flex;display:flex;height:%?110?%}.select-view1[data-v-03f1a8ce]{display:-webkit-box;display:-webkit-flex;display:flex;height:%?110?%;position:relative}.select-name[data-v-03f1a8ce]{margin-left:%?40?%;margin-top:6%;font-size:%?25?%;width:26%}.select-text[data-v-03f1a8ce]{margin-left:%?20?%;margin-top:6%;font-size:%?25?%;color:#666}.select-text1[data-v-03f1a8ce]{position:absolute;top:%?40?%;left:%?240?%;font-size:%?25?%;color:#666}.hengxian[data-v-03f1a8ce]{width:94%;height:1px;background-color:#dbdada;margin-left:3%}.ckeck[data-v-03f1a8ce]{width:90%;margin-left:5%;font-size:%?28?%;margin-top:3%}uni-button[data-v-03f1a8ce]{width:80%;margin-top:%?50?%;background-color:#ff8c00;border-radius:%?40?% %?40?% %?40?% %?40?%;color:#fff}.picker[data-v-03f1a8ce]{width:100%;text-align:left;color:#777;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}.default-checkbox[data-v-03f1a8ce]{margin-right:%?6?%}.cu-form-group .title[data-v-03f1a8ce]{min-width:calc(4em + 15px)}body.?%PAGE?%[data-v-03f1a8ce]{background-color:#f7f7f7}",""]),e.exports=t},"356f":function(e,t,a){"use strict";var i={wPicker:a("6ade").default},o=function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("v-uni-view",{staticClass:"ID"},[a("v-uni-view",{staticClass:"indexs"},[a("v-uni-view",{staticClass:"cu-form-group"},[a("v-uni-view",{staticClass:"title"},[e._v("收货人")]),a("v-uni-input",{attrs:{placeholder:"请填写姓名"},model:{value:e.addressInfo.name,callback:function(t){e.$set(e.addressInfo,"name",t)},expression:"addressInfo.name"}})],1),a("v-uni-view",{staticClass:"cu-form-group"},[a("v-uni-view",{staticClass:"title"},[e._v("联系电话")]),a("v-uni-input",{attrs:{placeholder:"请填写手机号码"},model:{value:e.addressInfo.tel,callback:function(t){e.$set(e.addressInfo,"tel",t)},expression:"addressInfo.tel"}})],1),a("v-uni-view",{staticClass:"cu-form-group"},[a("v-uni-view",{staticClass:"title"},[e._v("所在地区")]),a("v-uni-view",{staticClass:"w-picker picker",on:{click:function(t){arguments[0]=t=e.$handleEvent(t),e.toggleTab("region")}}},[e._v(e._s(e.resultInfo.result))]),a("w-picker",{ref:"region",attrs:{mode:"region",defaultVal:e.regionDval,areaCode:["11","1101","110101"],hideArea:!1,timeout:!0},on:{confirm:function(t){arguments[0]=t=e.$handleEvent(t),e.onConfirm.apply(void 0,arguments)}}})],1),a("v-uni-view",{staticClass:"cu-form-group"},[a("v-uni-view",{staticClass:"title"},[e._v("详细地址")]),a("v-uni-input",{attrs:{placeholder:"请填写详细地址"},model:{value:e.addressInfo.detail,callback:function(t){e.$set(e.addressInfo,"detail",t)},expression:"addressInfo.detail"}})],1),a("v-uni-view",{staticClass:"cu-form-group"},[a("v-uni-checkbox-group",{on:{change:function(t){arguments[0]=t=e.$handleEvent(t),e.defaultCheck.apply(void 0,arguments)}}},[a("v-uni-checkbox",{attrs:{checked:1==e.is_default,value:"1",color:"#ED6E11"}}),a("v-uni-text",{staticClass:"moren"},[e._v("默认")])],1)],1)],1),a("v-uni-view",[a("v-uni-button",{on:{click:function(t){arguments[0]=t=e.$handleEvent(t),e.addressEdit.apply(void 0,arguments)}}},[e._v("保 存")])],1),e.loadModal.show?a("v-uni-view",{staticClass:"cu-load load-modal"},[a("v-uni-image",{attrs:{src:"/static/public/loading.png",mode:"aspectFit"}}),a("v-uni-view",{staticClass:"gray-text"},[e._v(e._s(e.loadModal.text))])],1):e._e()],1)},n=[];a.d(t,"b",(function(){return o})),a.d(t,"c",(function(){return n})),a.d(t,"a",(function(){return i}))},"58a4":function(e,t,a){"use strict";Object.defineProperty(t,"__esModule",{value:!0}),t.default=void 0;var i="http://livechb3.changhuoban.com/api",o=i;t.default=o},"710a":function(e,t,a){var i=a("1095");"string"===typeof i&&(i=[[e.i,i,""]]),i.locals&&(e.exports=i.locals);var o=a("4f06").default;o("9e076f2e",i,!0,{sourceMap:!1,shadowMode:!1})},a50c:function(e,t,a){"use strict";var i=a("ee27");Object.defineProperty(t,"__esModule",{value:!0}),t.default=void 0;var o=i(a("f3f3")),n=i(a("6ade")),s=i(a("d1d1")),d={components:{wPicker:n.default},data:function(){return{loadModal:{show:!1,text:"提交中..."},title:"Hello",startYear:(new Date).getFullYear(),regionDval:["北京市","市辖区","东城区"],resultInfo:{result:"请选择所在地区"},addressInfo:{},is_default:""}},onLoad:function(e){var t=e.address_id;this.loadModal.show=!0,this.getAddressInfo(t)},methods:{toggleTab:function(e){this.$refs[e].show()},onConfirm:function(e){this.resultInfo=(0,o.default)({},e),console.log(this.resultInfo)},defaultCheck:function(e){this.is_default=1==e.detail.value?1:0},getAddressInfo:function(e){var t=this;(0,s.default)({url:"/V1/getFirstAddress",method:"GET",data:{id:e},success:function(e){if(t.loadModal.show=!1,e.data.success){t.addressInfo=e.data.success.data;var a=t.addressInfo.province,i=t.addressInfo.city,o=t.addressInfo.area;t.resultInfo.result=a+i+o,t.resultInfo.checkArr=[a,i,o],t.is_default=t.addressInfo.is_default}else uni.showToast({title:e.data.error.message,icon:"none"})}})},addressEdit:function(){var e=this,t=/^1[356789]\d{9}$/;return""==this.addressInfo.name?(uni.showToast({title:"请填写收货人姓名",icon:"none"}),!1):t.test(this.addressInfo.tel)?void 0==this.resultInfo.checkArr?(uni.showToast({title:"请选择所在地区",icon:"none"}),!1):""==this.addressInfo.detail?(uni.showToast({title:"请填写详细地址",icon:"none"}),!1):(this.loadModal.show=!0,void(0,s.default)({url:"/V1/upAddress",method:"GET",data:{id:this.addressInfo.id,name:this.addressInfo.name,tel:this.addressInfo.tel,province:this.resultInfo.checkArr[0],city:this.resultInfo.checkArr[1],area:this.resultInfo.checkArr[2],detail:this.addressInfo.detail,is_default:this.is_default},success:function(t){e.loadModal.show=!1,console.log(t);try{t.data.success?(uni.showToast({title:"修改成功",icon:"none"}),setTimeout((function(){uni.navigateBack()}),1e3)):uni.showToast({title:t.data.error.message,icon:"none"})}catch(a){uni.showToast({title:"系统错误，请联系客服",icon:"none"})}}})):(uni.showToast({title:"手机号格式不正确",icon:"none"}),!1)}}};t.default=d},bad0:function(e,t,a){"use strict";a.r(t);var i=a("356f"),o=a("e04a");for(var n in o)"default"!==n&&function(e){a.d(t,e,(function(){return o[e]}))}(n);a("e1c7");var s,d=a("f0c5"),r=Object(d["a"])(o["default"],i["b"],i["c"],!1,null,"03f1a8ce",null,!1,i["a"],s);t["default"]=r.exports},d1d1:function(e,t,a){"use strict";var i=a("ee27");Object.defineProperty(t,"__esModule",{value:!0}),t.default=void 0;var o=i(a("58a4")),n=function(e){e.url=o.default+e.url;try{var t=uni.getStorageSync("token"),a=uni.getStorageSync("operate"),i=uni.getStorageSync("type");if(""==t)return void uni.redirectTo({url:"/pages/index/index"});if(""==a)return void uni.redirectTo({url:"/pages/index/index"});if(""==i)return void uni.redirectTo({url:"/pages/index/index"});uni.request({url:e.url,header:{Authorization:"Bearer "+t},method:e.method,data:e.data,success:function(t){if(200==t.statusCode&&e.success(t),505==t.statusCode)return uni.showToast({title:"登录失效",icon:"none",mask:!0,position:"bottom"}),void setTimeout((function(){uni.redirectTo({url:"/pages/index/index"})}),1e3)}})}catch(n){uni.showToast({title:"系统错误，请联系客服",icon:"none",position:"bottom"})}},s=n;t.default=s},e04a:function(e,t,a){"use strict";a.r(t);var i=a("a50c"),o=a.n(i);for(var n in i)"default"!==n&&function(e){a.d(t,e,(function(){return i[e]}))}(n);t["default"]=o.a},e1c7:function(e,t,a){"use strict";var i=a("710a"),o=a.n(i);o.a}}]);