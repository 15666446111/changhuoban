(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["pages-mine-shimingrenzheng-shimingrenzheng"],{1481:function(i,t,e){"use strict";e.r(t);var n=e("e564"),a=e("5d0a");for(var s in a)"default"!==s&&function(i){e.d(t,i,(function(){return a[i]}))}(s);e("60ed");var c,r=e("f0c5"),o=Object(r["a"])(a["default"],n["b"],n["c"],!1,null,"8fee8f90",null,!1,n["a"],c);t["default"]=o.exports},"5d0a":function(i,t,e){"use strict";e.r(t);var n=e("f480"),a=e.n(n);for(var s in n)"default"!==s&&function(i){e.d(t,i,(function(){return n[i]}))}(s);t["default"]=a.a},"60ed":function(i,t,e){"use strict";var n=e("c3ad"),a=e.n(n);a.a},bece:function(i,t,e){var n=e("24fb");t=n(!1),t.push([i.i,".renzheng[data-v-8fee8f90]{width:100%}.picture[data-v-8fee8f90]{width:48%;margin-left:1%;margin-top:2%\r\n/* \tbackground-color: #fff;\r\n\tborder-radius: 15px 15px 15px 15px; */}.renzheng[data-v-8fee8f90]{display:-webkit-box;display:-webkit-flex;display:flex}.img[data-v-8fee8f90]{width:90%;margin-left:%?20?%;margin-top:%?20?%}.name[data-v-8fee8f90]{text-align:center;font-size:%?25?%;color:#666}.text[data-v-8fee8f90]{text-align:center;margin-top:%?5?%;font-size:%?30?%}uni-button[data-v-8fee8f90]{width:80%;background-color:#ff8c00;color:#fff;margin-top:%?100?%;border-radius:5px}.url[data-v-8fee8f90]{width:%?700?%;margin:0 auto}",""]),i.exports=t},c3ad:function(i,t,e){var n=e("bece");"string"===typeof n&&(n=[[i.i,n,""]]),n.locals&&(i.exports=n.locals);var a=e("4f06").default;a("4864077c",n,!0,{sourceMap:!1,shadowMode:!1})},e564:function(i,t,e){"use strict";var n,a=function(){var i=this,t=i.$createElement,e=i._self._c||t;return e("v-uni-view",[e("v-uni-view",{staticClass:"shiming"},[e("v-uni-view",{staticClass:"renzheng"},[e("v-uni-view",{staticClass:"picture",on:{click:function(t){arguments[0]=t=i.$handleEvent(t),i.chooseimge("idcard_before")}}},[e("v-uni-image",{staticClass:"img",attrs:{src:i.idcard_before,mode:"widthFix"}}),e("v-uni-view",{staticClass:"name"},[i._v("身份征正面")]),e("v-uni-view",{staticClass:"text"},[i._v("（文字清晰,四角齐全）")])],1),e("v-uni-view",{staticClass:"picture",on:{click:function(t){arguments[0]=t=i.$handleEvent(t),i.chooseimge("idcard_after")}}},[e("v-uni-image",{staticClass:"img",attrs:{src:i.idcard_after,mode:"widthFix"}}),e("v-uni-view",{staticClass:"name"},[i._v("身份征反面")]),e("v-uni-view",{staticClass:"text"},[i._v("（文字清晰,四角齐全）")])],1)],1),e("v-uni-view",{staticClass:"renzheng"},[e("v-uni-view",{staticClass:"picture",on:{click:function(t){arguments[0]=t=i.$handleEvent(t),i.chooseimge("idcard_house")}}},[e("v-uni-image",{staticClass:"img",attrs:{src:i.idcard_house,mode:"widthFix"}}),e("v-uni-view",{staticClass:"name"},[i._v("手持身份证")]),e("v-uni-view",{staticClass:"text"},[i._v("（文字清晰,四角齐全）")])],1),e("v-uni-view",{staticClass:"picture",on:{click:function(t){arguments[0]=t=i.$handleEvent(t),i.chooseimge("bank_before")}}},[e("v-uni-image",{staticClass:"img",attrs:{src:i.bank_before,mode:"widthFix"}}),e("v-uni-view",{staticClass:"name"},[i._v("银行卡正面")]),e("v-uni-view",{staticClass:"text"},[i._v("（文字清晰,四角齐全）")])],1)],1)],1),e("v-uni-navigator",{staticClass:"url",attrs:{"hover-class":"none",url:"shimingxinxi/shimingxinxi"}},[e("v-uni-button",{staticClass:"button-1",attrs:{id:"button-1"}},[i._v("下 一 步")])],1)],1)},s=[];e.d(t,"b",(function(){return a})),e.d(t,"c",(function(){return s})),e.d(t,"a",(function(){return n}))},f480:function(i,t,e){"use strict";Object.defineProperty(t,"__esModule",{value:!0}),t.default=void 0;var n={data:function(){return{idcard_before:"/static/shuzi/IDcard.png",idcard_after:"/static/shuzi/IDcard2.png",idcard_house:"/static/shuzi/Idcard3.png",bank_before:"/static/shuzi/bank_card.png"}},methods:{chooseimge:function(i){var t=this;uni.chooseImage({count:1,sizeType:["original","compressed"],sourceType:["album"],success:function(i){uni.getImageInfo({src:i.tempFilePaths[0],success:function(i){t.index=JSON.stringify(i.path),console.log(i)}}),console.log(t.index),console.log(JSON.stringify(i.tempFilePaths))}})}}};t.default=n}}]);