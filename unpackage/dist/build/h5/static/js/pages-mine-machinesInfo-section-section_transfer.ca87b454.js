(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["pages-mine-machinesInfo-section-section_transfer"],{"4cd8":function(t,e,i){"use strict";i.r(e);var a=i("c214"),n=i("5932");for(var o in n)"default"!==o&&function(t){i.d(e,t,(function(){return n[t]}))}(o);i("f1b5");var s,d=i("f0c5"),r=Object(d["a"])(n["default"],a["b"],a["c"],!1,null,"7a11df1a",null,!1,a["a"],s);e["default"]=r.exports},"58a4":function(t,e,i){"use strict";Object.defineProperty(e,"__esModule",{value:!0}),e.default=void 0;var a="http://livechb3.changhuoban.com/api",n=a;e.default=n},5932:function(t,e,i){"use strict";i.r(e);var a=i("cbca"),n=i.n(a);for(var o in a)"default"!==o&&function(t){i.d(e,t,(function(){return a[t]}))}(o);e["default"]=n.a},"6af5":function(t,e,i){var a=i("bfbe");"string"===typeof a&&(a=[[t.i,a,""]]),a.locals&&(t.exports=a.locals);var n=i("4f06").default;n("19ec22a8",a,!0,{sourceMap:!1,shadowMode:!1})},bfbe:function(t,e,i){var a=i("24fb");e=a(!1),e.push([t.i,"uni-page[data-v-7a11df1a]{overflow:hidden}.button[data-v-7a11df1a]{position:fixed;width:100%;background-color:#ff8c00;bottom:0;height:%?90?%;text-align:center;line-height:%?90?%;color:#fff;font-size:%?35?%}\r\n\r\n/* SN选择 */.start-over[data-v-7a11df1a]{background-color:#fff;width:92%;margin-left:4%;margin-top:%?20?%;overflow:hidden;box-shadow:#efe9e9 3px 3px 8px 3px;border-radius:7px 7px 7px 7px;height:%?430?%}.select[data-v-7a11df1a]{width:100%;height:%?100?%;line-height:%?100?%;position:relative;display:-webkit-box;display:-webkit-flex;display:flex}.select-name[data-v-7a11df1a]{font-size:%?33?%;margin-left:%?30?%;color:#333}.select-img[data-v-7a11df1a]{width:%?60?%;height:%?60?%;position:absolute;top:%?20?%;right:%?10?%}.select-xian[data-v-7a11df1a]{width:100%;height:%?1?%;background-color:#f1f1f1}.hint[data-v-7a11df1a]{color:#999;text-align:center;height:%?90?%;line-height:%?80?%}.select-button[data-v-7a11df1a]{background-color:#ff8c00;color:#fff;width:60%;margin-left:20%;height:%?70?%;text-align:center;line-height:%?70?%;font-size:%?35?%}\r\n\r\n/* SN显示 */.show[data-v-7a11df1a]{background-color:#fff;width:92%;height:%?600?%;margin-left:4%;margin-top:%?20?%;overflow:hidden;overflow-y:auto;box-shadow:#efe9e9 3px 3px 8px 3px;border-radius:7px 7px 7px 7px}.show-title[data-v-7a11df1a]{display:-webkit-box;display:-webkit-flex;display:flex;width:100%;height:%?70?%;line-height:%?70?%}.title-name[data-v-7a11df1a]{width:40%;text-align:center;font-size:%?30?%}.title-text[data-v-7a11df1a]{width:20%;text-align:center;font-size:%?30?%}.amount[data-v-7a11df1a]{width:20%;display:-webkit-box;display:-webkit-flex;display:flex;position:relative;text-align:center;height:%?80?%;line-height:%?80?%}.sn-amount[data-v-7a11df1a]{width:70%;height:%?80?%;line-height:%?80?%}.sn-img[data-v-7a11df1a]{width:%?40?%;height:%?40?%;position:absolute;right:%?20?%;top:%?18?%}.show-sn[data-v-7a11df1a]{width:100%;display:-webkit-box;display:-webkit-flex;display:flex;height:%?80?%;line-height:%?80?%}.sn-name[data-v-7a11df1a]{width:40%;text-align:center;height:%?80?%;line-height:%?80?%}.sn-input[data-v-7a11df1a]{height:100%}.checkbox-view[data-v-7a11df1a]{width:92%;height:%?100?%;line-height:%?100?%;border-radius:%?15?% %?15?% %?15?% %?15?%;position:relative;margin:0 4%;border-bottom:1px solid #eee}.checkbox-text[data-v-7a11df1a]{font-size:%?31?%;color:#333}.checkbox[data-v-7a11df1a]{position:absolute;right:0}",""]),t.exports=e},c214:function(t,e,i){"use strict";var a,n=function(){var t=this,e=t.$createElement,i=t._self._c||e;return i("v-uni-view",[i("v-uni-view",{staticClass:"start-over"},[i("v-uni-view",{staticClass:"select"},[i("v-uni-text",{staticClass:"select-name"},[t._v("机具起始SN：")]),i("v-uni-input",{staticClass:"sn-input",attrs:{type:"text",placeholder:"请输入起始SN号"},model:{value:t.startSn,callback:function(e){t.startSn=e},expression:"startSn"}})],1),i("v-uni-view",{staticClass:"select-xian"}),i("v-uni-view",{staticClass:"select"},[i("v-uni-text",{staticClass:"select-name"},[t._v("机具结束SN：")]),i("v-uni-input",{staticClass:"sn-input",attrs:{type:"text",value:"",placeholder:"请输入结束SN号"},model:{value:t.endSn,callback:function(e){t.endSn=e},expression:"endSn"}})],1),i("v-uni-view",{staticClass:"select-xian"}),i("v-uni-view",{staticClass:"hint"},[t._v("提示:区间划拨可能存在序列号间断，或已激活")]),i("v-uni-view",{staticClass:"select-button",on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.getSectionMachines.apply(void 0,arguments)}}},[t._v("查 询")])],1),i("v-uni-view",{staticClass:"show"},[i("v-uni-checkbox-group",{on:{change:function(e){arguments[0]=e=t.$handleEvent(e),t.optTerminal.apply(void 0,arguments)}}},t._l(t.show,(function(e,a){return i("v-uni-view",{key:a},[i("v-uni-view",{staticClass:"checkbox-view"},[i("v-uni-text",{staticClass:"checkbox-text"},[t._v("SN："+t._s(e.sn))]),i("v-uni-checkbox",{staticClass:"checkbox",attrs:{value:e.id,checked:"true",color:"#f98021"}})],1),i("v-uni-view",{staticClass:"xian"})],1)})),1)],1),i("v-uni-view",{staticStyle:{height:"100upx"}}),i("v-uni-view",{staticClass:"button",on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.transfer.apply(void 0,arguments)}}},[t._v("确 认 选 择"),i("v-uni-text",[t._v("（"+t._s(t.transferNum)+"）")])],1),t.loadModal.show?i("v-uni-view",{staticClass:"cu-load load-modal"},[i("v-uni-image",{attrs:{src:"/static/public/loading.png",mode:"aspectFit"}}),i("v-uni-view",{staticClass:"gray-text"},[t._v(t._s(t.loadModal.text))])],1):t._e()],1)},o=[];i.d(e,"b",(function(){return n})),i.d(e,"c",(function(){return o})),i.d(e,"a",(function(){return a}))},cbca:function(t,e,i){"use strict";var a=i("ee27");i("4160"),i("159b"),Object.defineProperty(e,"__esModule",{value:!0}),e.default=void 0;var n=a(i("d1d1")),o={data:function(){return{loadModal:{show:!1,text:"加载中..."},partnerId:"",policyId:"",termIds:[],startSn:"",endSn:"",transferNum:0,show:{}}},onLoad:function(t){this.partnerId=t.uid,this.policyId=t.policy_id},methods:{getSectionMachines:function(){var t=this;return""==this.policyId||void 0==this.policyId?(uni.showToast({title:"请选择划拨政策",icon:"none",position:"bottom"}),!1):""==this.partnerId||void 0==this.partnerId?(uni.showToast({title:"请选择划拨用户",icon:"none",position:"bottom"}),!1):""==this.startSn||void 0==this.startSn?(uni.showToast({title:"请输入起始SN号",icon:"none",position:"bottom"}),!1):""==this.startSn||void 0==this.startSn?(uni.showToast({title:"请输入结束SN号",icon:"none",position:"bottom"}),!1):(this.loadModal={show:!0,text:"查询中..."},void(0,n.default)({url:"/V1/sectionPolicy",method:"GET",data:{policy_id:this.policyId,begin_sn:this.startSn,end_sn:this.endSn},success:function(e){if(console.log(e),t.loadModal.show=!1,e.data.success){t.show=e.data.success.data,t.transferNum=t.show.length;var i=t;t.show.forEach((function(t,e){i.termIds[e]=t.id}))}else uni.showToast({title:e.data.error.message,icon:"none",position:"bottom"})}}))},optTerminal:function(t){this.termIds=t.target.value,this.transferNum=t.detail.value.length},transfer:function(){var t=this;this.loadModal={show:!0,text:"划拨中..."},(0,n.default)({url:"/V1/addTransfer",method:"POST",data:{id:this.termIds,friend_id:this.partnerId},success:function(e){t.loadModal.show=!1;var i=t;e.data.success?(uni.showToast({title:"划拨成功",icon:"none"}),setTimeout((function(){uni.redirectTo({url:"section_transfer?policy_id="+i.policyId+"&uid="+i.partnerId})}),1500)):uni.showToast({title:e.data.error.message,icon:"none"})}})}}};e.default=o},d1d1:function(t,e,i){"use strict";var a=i("ee27");Object.defineProperty(e,"__esModule",{value:!0}),e.default=void 0;var n=a(i("58a4")),o=function(t){t.url=n.default+t.url;try{var e=uni.getStorageSync("token"),i=uni.getStorageSync("operate"),a=uni.getStorageSync("type");if(""==e)return void uni.redirectTo({url:"/pages/index/index"});if(""==i)return void uni.redirectTo({url:"/pages/index/index"});if(""==a)return void uni.redirectTo({url:"/pages/index/index"});uni.request({url:t.url,header:{Authorization:"Bearer "+e},method:t.method,data:t.data,success:function(e){if(200==e.statusCode&&t.success(e),505==e.statusCode)return uni.showToast({title:"登录失效",icon:"none",mask:!0,position:"bottom"}),void setTimeout((function(){uni.redirectTo({url:"/pages/index/index"})}),1e3)}})}catch(o){uni.showToast({title:"系统错误，请联系客服",icon:"none",position:"bottom"})}},s=o;e.default=s},f1b5:function(t,e,i){"use strict";var a=i("6af5"),n=i.n(a);n.a}}]);