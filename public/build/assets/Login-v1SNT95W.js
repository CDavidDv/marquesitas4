import{T as _,o as n,e as d,b as s,u as a,w as m,F as b,Z as g,t as w,f as x,a as t,n as V,g as k,i as v}from"./app-C8CjfH1x.js";import{A as h}from"./AuthenticationCard-O3wWwrws.js";import{_ as y}from"./AuthenticationCardLogo-BrPWwKnT.js";import{_ as $}from"./Checkbox-C2aK64Zn.js";import{_ as c,a as u}from"./TextInput-DyOnmkqD.js";import{_ as p}from"./InputLabel-Jeh4ovdk.js";import{_ as B}from"./PrimaryButton-DtbEAGXb.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";const C={key:0,class:"mb-4 font-medium text-sm text-green-600"},N={class:"mt-4"},S={class:"block mt-4"},F={class:"flex items-center"},U=t("span",{class:"ms-2 text-sm text-gray-600"},"Recuérdame",-1),q={class:"flex items-center justify-end mt-4"},L={__name:"Login",props:{canResetPassword:Boolean,status:String},setup(l){const e=_({email:"",password:"",remember:!1}),f=()=>{e.transform(i=>({...i,remember:e.remember?"on":""})).post(route("login"),{onFinish:()=>e.reset("password")})};return(i,o)=>(n(),d(b,null,[s(a(g),{title:"Bienvenido"}),s(h,null,{logo:m(()=>[s(y)]),default:m(()=>[l.status?(n(),d("div",C,w(l.status),1)):x("",!0),t("form",{onSubmit:v(f,["prevent"])},[t("div",null,[s(p,{for:"email",value:"Email"}),s(c,{id:"email",modelValue:a(e).email,"onUpdate:modelValue":o[0]||(o[0]=r=>a(e).email=r),type:"email",class:"mt-1 block w-full",required:"",autofocus:"",autocomplete:"username"},null,8,["modelValue"]),s(u,{class:"mt-2",message:a(e).errors.email},null,8,["message"])]),t("div",N,[s(p,{for:"password",value:"Contraseña"}),s(c,{id:"password",modelValue:a(e).password,"onUpdate:modelValue":o[1]||(o[1]=r=>a(e).password=r),type:"password",class:"mt-1 block w-full",required:"",autocomplete:"current-password"},null,8,["modelValue"]),s(u,{class:"mt-2",message:a(e).errors.password},null,8,["message"])]),t("div",S,[t("label",F,[s($,{checked:a(e).remember,"onUpdate:checked":o[2]||(o[2]=r=>a(e).remember=r),name:"remember"},null,8,["checked"]),U])]),t("div",q,[s(B,{class:V(["ms-4",{"opacity-25":a(e).processing}]),disabled:a(e).processing},{default:m(()=>[k(" Iniciar Sesión ")]),_:1},8,["class","disabled"])])],32)]),_:1})],64))}};export{L as default};
