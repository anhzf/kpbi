(window.webpackJsonp=window.webpackJsonp||[]).push([[7],{PnY8:function(t,e,n){"use strict";n.r(e);var r=n("o0o1"),a=n.n(r);function i(t,e,n,r,a,i,s){try{var o=t[i](s),c=o.value}catch(t){return void n(t)}o.done?e(c):Promise.resolve(c).then(r,a)}function s(t){return function(){var e=this,n=arguments;return new Promise((function(r,a){var s=t.apply(e,n);function o(t){i(s,r,a,o,c,"next",t)}function c(t){i(s,r,a,o,c,"throw",t)}o(void 0)}))}}var o={name:"Verify",methods:{verify:function(){var t=this;return s(a.a.mark((function e(){var n;return a.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:if(t.$store.commit("contentLoading",!0),t.$route.params.id==t.$store.getters.userId){e.next=3;break}return e.abrupt("return",t.$emit("notice",{message:"Link verifikasi tidak sesuai, Silahkan Log in menggunakan akun yang lain",type:"error"}));case 3:return e.prev=3,e.next=6,window.axios.post(app.$route.fullPath);case 6:n=e.sent,t.$emit("notice",{message:n.data.message,type:"success"}),t.$router.push({name:"AccountSettings"}),e.next=14;break;case 11:e.prev=11,e.t0=e.catch(3),t.$emit("noticeError",e.t0);case 14:t.$store.commit("contentLoading",!1);case 15:case"end":return e.stop()}}),e,null,[[3,11]])})))()}},mounted:function(){var t=this;return s(a.a.mark((function e(){return a.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:t.verify();case 1:case"end":return e.stop()}}),e)})))()}},c=n("KHd+"),u=Object(c.a)(o,(function(){var t=this.$createElement,e=this._self._c||t;return e("v-container",{staticClass:"fill-height",attrs:{fluid:""}},[e("v-row",{attrs:{justify:"center"}},[e("h1",{staticClass:"text-h4"},[this._v("Memverifikasi...")])])],1)}),[],!1,null,null,null);e.default=u.exports}}]);