(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["pages-mine-bankSet-updatePwd-updatePwd"],{"068f":function(t,e,a){var n=a("24fb");e=n(!1),e.push([t.i,".bank-card[data-v-6e19ac00]{box-shadow:#d9d9d9 0 0 4px 0;margin-top:%?20?%}.bank[data-v-6e19ac00]{display:-webkit-box;display:-webkit-flex;display:flex;width:100%;position:relative;height:%?80?%;background-color:#fff}.bank-name[data-v-6e19ac00]{width:25%;height:%?80?%;line-height:%?80?%;font-size:%?28?%;margin-left:3%}.bank-text[data-v-6e19ac00]{width:45%;margin-top:%?5?%;font-size:%?28?%;color:#777;margin-left:%?15?%}.wxbox[data-v-6e19ac00]{height:%?80?%;line-height:%?100?%;padding-top:%?20?%}.wx[data-v-6e19ac00]{width:8%;margin-left:3%}.bank-img[data-v-6e19ac00]{width:4%;position:absolute;right:5%;top:%?25?%}.add-xian[data-v-6e19ac00]{width:100%;height:1px;background-color:#c5c3c3}\r\n\r\n/** 修改密码 **/.old[data-v-6e19ac00]{background-color:#fff;margin-top:%?20?%;height:%?70?%;padding-left:30px}.new[data-v-6e19ac00]{background-color:#fff;margin-top:%?20?%;height:%?80?%;padding-left:30px}.new2[data-v-6e19ac00]{padding-left:30px;background-color:#fff;margin-top:%?5?%;height:%?80?%}.psy[data-v-6e19ac00]{width:96%;height:%?80?%;background-color:#ff6358;color:#fff;text-align:center;margin-top:%?30?%;border-radius:%?5?%;font-size:%?40?%;line-height:%?80?%}",""]),t.exports=e},"39df":function(t,e,a){"use strict";var n=a("7aff"),i=a.n(n);i.a},"58a4":function(t,e,a){"use strict";Object.defineProperty(e,"__esModule",{value:!0}),e.default=void 0;var n="http://livechb3.changhuoban.com/api",i=n;e.default=i},"6f6d":function(t,e,a){"use strict";var n=a("ee27");a("4160"),a("159b"),Object.defineProperty(e,"__esModule",{value:!0}),e.default=void 0;var i=n(a("d1d1")),o={data:function(){return{loadModal:{show:!1,text:"提交中..."},oldPass:"",newPass:"",newPassAgain:"",applyText:"<div>345</div>",rules:{oldPass:[{rule:/^.{6,16}$/,msg:"密码格式不正确，长度为6-16个字符"}],newPass:[{rule:/^.{6,16}$/,msg:"密码格式不正确，长度为6-16个字符"}]}}},methods:{validate:function(t){var e=this,a=!0;return this.rules[t].forEach((function(n){if(!n.rule.test(e[t]))return uni.showToast({title:n.msg,icon:"none",position:"bottom"}),a=!1,!1})),a},submit:function(){var t=this;return!!this.validate("oldPass")&&(!!this.validate("newPass")&&(this.newPassAgain!=this.newPass?(uni.showToast({title:"两次输入的密码不一致",icon:"none",position:"bottom"}),!1):(this.loadModal.show=!0,void(0,i.default)({url:"/V1/setUserPwd",method:"get",data:{password:this.oldPass,newPassword:this.newPass},success:function(e){t.loadModal.show=!1,e.data.success?uni.showToast({title:e.data.success.message,icon:"none",success:function(){setTimeout((function(){uni.navigateBack()}),1500)}}):uni.showToast({title:e.data.error.message,icon:"none"})}}))))}}};e.default=o},"7aff":function(t,e,a){var n=a("068f");"string"===typeof n&&(n=[[t.i,n,""]]),n.locals&&(t.exports=n.locals);var i=a("4f06").default;i("13025a40",n,!0,{sourceMap:!1,shadowMode:!1})},9381:function(t,e,a){"use strict";var n,i=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("v-uni-view",{staticClass:"body"},[a("v-uni-view",{staticClass:"bview"},[a("v-uni-input",{staticClass:"old",attrs:{type:"password",placeholder:"旧密码"},model:{value:t.oldPass,callback:function(e){t.oldPass=e},expression:"oldPass"}})],1),a("v-uni-view",[a("v-uni-input",{staticClass:"new",attrs:{type:"password",placeholder:"新密码"},model:{value:t.newPass,callback:function(e){t.newPass=e},expression:"newPass"}}),a("v-uni-input",{staticClass:"new2",attrs:{type:"password",placeholder:"确认新密码"},model:{value:t.newPassAgain,callback:function(e){t.newPassAgain=e},expression:"newPassAgain"}})],1),a("v-uni-button",{staticClass:"psy",on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.submit.apply(void 0,arguments)}}},[t._v("确定")]),t.loadModal.show?a("v-uni-view",{staticClass:"cu-load load-modal"},[a("v-uni-image",{attrs:{src:"/static/public/loading.png",mode:"aspectFit"}}),a("v-uni-view",{staticClass:"gray-text"},[t._v(t._s(t.loadModal.text))])],1):t._e()],1)},o=[];a.d(e,"b",(function(){return i})),a.d(e,"c",(function(){return o})),a.d(e,"a",(function(){return n}))},b4e0:function(t,e,a){"use strict";a.r(e);var n=a("9381"),i=a("ddb2");for(var o in i)"default"!==o&&function(t){a.d(e,t,(function(){return i[t]}))}(o);a("39df");var s,d=a("f0c5"),r=Object(d["a"])(i["default"],n["b"],n["c"],!1,null,"6e19ac00",null,!1,n["a"],s);e["default"]=r.exports},d1d1:function(t,e,a){"use strict";var n=a("ee27");Object.defineProperty(e,"__esModule",{value:!0}),e.default=void 0;var i=n(a("58a4")),o=function(t){t.url=i.default+t.url;try{var e=uni.getStorageSync("token"),a=uni.getStorageSync("operate"),n=uni.getStorageSync("type");if(""==e)return void uni.redirectTo({url:"/pages/index/index"});if(""==a)return void uni.redirectTo({url:"/pages/index/index"});if(""==n)return void uni.redirectTo({url:"/pages/index/index"});uni.request({url:t.url,header:{Authorization:"Bearer "+e},method:t.method,data:t.data,success:function(e){if(200==e.statusCode&&t.success(e),505==e.statusCode)return uni.showToast({title:"登录失效",icon:"none",mask:!0,position:"bottom"}),void setTimeout((function(){uni.redirectTo({url:"/pages/index/index"})}),1e3)}})}catch(o){uni.showToast({title:"系统错误，请联系客服",icon:"none",position:"bottom"})}},s=o;e.default=s},ddb2:function(t,e,a){"use strict";a.r(e);var n=a("6f6d"),i=a.n(n);for(var o in n)"default"!==o&&function(t){a.d(e,t,(function(){return n[t]}))}(o);e["default"]=i.a}}]);