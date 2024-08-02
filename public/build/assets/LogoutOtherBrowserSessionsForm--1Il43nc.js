import{d as h,T as k,o as r,c as x,w as e,g as a,e as n,F as y,h as V,f as b,a as o,b as i,u as c,H as C,n as A,t as l}from"./app-C8CjfH1x.js";import{_ as B}from"./ActionMessage-CfMt8Ivc.js";import{a as S,b as H}from"./DialogModal-DOFbbBGz.js";import{_ as $,a as L}from"./TextInput-DyOnmkqD.js";import{_ as v}from"./PrimaryButton-DtbEAGXb.js";import{_ as F}from"./SecondaryButton-DYFqzrYG.js";import"./SectionTitle-DsPVdI1v.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";const M=o("div",{class:"max-w-xl text-sm text-gray-600"}," Si es necesario deberías cambiar o administrar las sesiones entre dispositivos. Algunas de los inicios de sesión están listadas a continuación, de cualquier manera debería de administrar o si cree que su cuenta se vio comprometida, debería de cambiar la contraseña ",-1),N={key:0,class:"mt-5 space-y-6"},T={key:0,class:"w-8 h-8 text-gray-500",xmlns:"http://www.w3.org/2000/svg",fill:"none",viewBox:"0 0 24 24","stroke-width":"1.5",stroke:"currentColor"},j=o("path",{"stroke-linecap":"round","stroke-linejoin":"round",d:"M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0V12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 12V5.25"},null,-1),U=[j],q={key:1,class:"w-8 h-8 text-gray-500",xmlns:"http://www.w3.org/2000/svg",fill:"none",viewBox:"0 0 24 24","stroke-width":"1.5",stroke:"currentColor"},E=o("path",{"stroke-linecap":"round","stroke-linejoin":"round",d:"M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3"},null,-1),I=[E],K={class:"ms-3"},O={class:"text-sm text-gray-600"},z={class:"text-xs text-gray-500"},D={key:0,class:"text-green-500 font-semibold"},P={key:1},G={class:"flex items-center mt-5"},J={class:"mt-4"},ts={__name:"LogoutOtherBrowserSessionsForm",props:{sessions:Array},setup(_){const d=h(!1),m=h(null),t=k({password:""}),w=()=>{d.value=!0,setTimeout(()=>m.value.focus(),250)},p=()=>{t.delete(route("other-browser-sessions.destroy"),{preserveScroll:!0,onSuccess:()=>u(),onError:()=>m.value.focus(),onFinish:()=>t.reset()})},u=()=>{d.value=!1,t.reset()};return(Q,f)=>(r(),x(S,null,{title:e(()=>[a(" Sesión de navegadores ")]),description:e(()=>[a(" Maneja tus inicios de sesión en los navegadores ")]),content:e(()=>[M,_.sessions.length>0?(r(),n("div",N,[(r(!0),n(y,null,V(_.sessions,(s,g)=>(r(),n("div",{key:g,class:"flex items-center"},[o("div",null,[s.agent.is_desktop?(r(),n("svg",T,U)):(r(),n("svg",q,I))]),o("div",K,[o("div",O,l(s.agent.platform?s.agent.platform:"Unknown")+" - "+l(s.agent.browser?s.agent.browser:"Unknown"),1),o("div",null,[o("div",z,[a(l(s.ip_address)+", ",1),s.is_current_device?(r(),n("span",D,"This device")):(r(),n("span",P,"Last active "+l(s.last_active),1))])])])]))),128))])):b("",!0),o("div",G,[i(v,{onClick:w},{default:e(()=>[a(" Cerrar sesión en otros dispositivos ")]),_:1}),i(B,{on:c(t).recentlySuccessful,class:"ms-3"},{default:e(()=>[a(" Hecho. ")]),_:1},8,["on"])]),i(H,{show:d.value,onClose:u},{title:e(()=>[a(" Cerrar sesión en otros dispositivos ")]),content:e(()=>[a(" Por favor ingrese su contraseña para confirma la acción "),o("div",J,[i($,{ref_key:"passwordInput",ref:m,modelValue:c(t).password,"onUpdate:modelValue":f[0]||(f[0]=s=>c(t).password=s),type:"password",class:"mt-1 block w-3/4",placeholder:"Contraseña",autocomplete:"current-password",onKeyup:C(p,["enter"])},null,8,["modelValue"]),i(L,{message:c(t).errors.password,class:"mt-2"},null,8,["message"])])]),footer:e(()=>[i(F,{onClick:u},{default:e(()=>[a(" Cancelar ")]),_:1}),i(v,{class:A(["ms-3",{"opacity-25":c(t).processing}]),disabled:c(t).processing,onClick:p},{default:e(()=>[a(" Cerrar sesión en otros dispositivos ")]),_:1},8,["class","disabled"])]),_:1},8,["show"])]),_:1}))}};export{ts as default};
