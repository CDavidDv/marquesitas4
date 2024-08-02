import{o as s,e as n,Q as A,d as $,I as D,n as p,a as e,f as h,t as y,i as x,B as F,C as E,l as C,r as f,J as S,u as v,m as B,K as L,b as u,w as r,L as I,c as b,j,Z as V,g as c,F as k,h as N,q as z}from"./app-C8CjfH1x.js";import{_ as J}from"./_plugin-vue_export-helper-DlAUqK2U.js";const O="/build/assets/logo-Bw370JaZ.png",R={},Z={src:O,height:"250",width:"250",alt:"logo"};function q(d,a){return s(),n("img",Z)}const H=J(R,[["render",q]]),K={class:"max-w-screen-xl mx-auto py-2 px-3 sm:px-6 lg:px-8"},Q={class:"flex items-center justify-between flex-wrap"},U={class:"w-0 flex-1 flex items-center min-w-0"},G={key:0,class:"h-5 w-5 text-white",xmlns:"http://www.w3.org/2000/svg",fill:"none",viewBox:"0 0 24 24","stroke-width":"1.5",stroke:"currentColor"},W=e("path",{"stroke-linecap":"round","stroke-linejoin":"round",d:"M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"},null,-1),X=[W],Y={key:1,class:"h-5 w-5 text-white",xmlns:"http://www.w3.org/2000/svg",fill:"none",viewBox:"0 0 24 24","stroke-width":"1.5",stroke:"currentColor"},ee=e("path",{"stroke-linecap":"round","stroke-linejoin":"round",d:"M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"},null,-1),te=[ee],se={class:"ms-3 font-medium text-sm text-white truncate"},oe={class:"shrink-0 sm:ms-3"},re=e("svg",{class:"h-5 w-5 text-white",xmlns:"http://www.w3.org/2000/svg",fill:"none",viewBox:"0 0 24 24","stroke-width":"1.5",stroke:"currentColor"},[e("path",{"stroke-linecap":"round","stroke-linejoin":"round",d:"M6 18L18 6M6 6l12 12"})],-1),ne=[re],ae={__name:"Banner",setup(d){const a=A(),o=$(!0),l=$("success"),t=$("");return D(async()=>{var _,i;l.value=((_=a.props.jetstream.flash)==null?void 0:_.bannerStyle)||"success",t.value=((i=a.props.jetstream.flash)==null?void 0:i.banner)||"",o.value=!0}),(_,i)=>(s(),n("div",null,[o.value&&t.value?(s(),n("div",{key:0,class:p({"bg-indigo-500":l.value=="success","bg-red-700":l.value=="danger"})},[e("div",K,[e("div",Q,[e("div",U,[e("span",{class:p(["flex p-2 rounded-lg",{"bg-indigo-600":l.value=="success","bg-red-600":l.value=="danger"}])},[l.value=="success"?(s(),n("svg",G,X)):h("",!0),l.value=="danger"?(s(),n("svg",Y,te)):h("",!0)],2),e("p",se,y(t.value),1)]),e("div",oe,[e("button",{type:"button",class:p(["-me-1 flex p-2 rounded-md focus:outline-none sm:-me-2 transition",{"hover:bg-indigo-600 focus:bg-indigo-600":l.value=="success","hover:bg-red-600 focus:bg-red-600":l.value=="danger"}]),"aria-label":"Dismiss",onClick:i[0]||(i[0]=x(g=>o.value=!1,["prevent"]))},ne,2)])])])],2)):h("",!0)]))}},ie={class:"relative"},P={__name:"Dropdown",props:{align:{type:String,default:"right"},width:{type:String,default:"48"},contentClasses:{type:Array,default:()=>["py-1","bg-white"]}},setup(d){const a=d;let o=$(!1);const l=i=>{o.value&&i.key==="Escape"&&(o.value=!1)};F(()=>document.addEventListener("keydown",l)),E(()=>document.removeEventListener("keydown",l));const t=C(()=>({48:"w-48"})[a.width.toString()]),_=C(()=>a.align==="left"?"ltr:origin-top-left rtl:origin-top-right start-0":a.align==="right"?"ltr:origin-top-right rtl:origin-top-left end-0":"origin-top");return(i,g)=>(s(),n("div",ie,[e("div",{onClick:g[0]||(g[0]=T=>S(o)?o.value=!v(o):o=!v(o))},[f(i.$slots,"trigger")]),B(e("div",{class:"fixed inset-0 z-40",onClick:g[1]||(g[1]=T=>S(o)?o.value=!1:o=!1)},null,512),[[L,v(o)]]),u(I,{"enter-active-class":"transition ease-out duration-200","enter-from-class":"transform opacity-0 scale-95","enter-to-class":"transform opacity-100 scale-100","leave-active-class":"transition ease-in duration-75","leave-from-class":"transform opacity-100 scale-100","leave-to-class":"transform opacity-0 scale-95"},{default:r(()=>[B(e("div",{class:p(["absolute z-50 mt-2 rounded-md shadow-lg",[t.value,_.value]]),style:{display:"none"},onClick:g[2]||(g[2]=T=>S(o)?o.value=!1:o=!1)},[e("div",{class:p(["rounded-md ring-1 ring-black ring-opacity-5",d.contentClasses])},[f(i.$slots,"content")],2)],2),[[L,v(o)]])]),_:3})]))}},le={key:0,type:"submit",class:"block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out"},ue=["href"],w={__name:"DropdownLink",props:{href:String,as:String},setup(d){return(a,o)=>(s(),n("div",null,[d.as=="button"?(s(),n("button",le,[f(a.$slots,"default")])):d.as=="a"?(s(),n("a",{key:1,href:d.href,class:"block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out"},[f(a.$slots,"default")],8,ue)):(s(),b(v(j),{key:2,href:d.href,class:"block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out"},{default:r(()=>[f(a.$slots,"default")]),_:3},8,["href"]))]))}},M={__name:"NavLink",props:{href:String,active:Boolean},setup(d){const a=d,o=C(()=>a.active?"inline-flex items-center px-1 pt-1 border-b-2 border-indigo-400 text-sm font-medium leading-5 text-gray-900 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out":"inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out");return(l,t)=>(s(),b(v(j),{href:d.href,class:p(o.value)},{default:r(()=>[f(l.$slots,"default")]),_:3},8,["href","class"]))}},m={__name:"ResponsiveNavLink",props:{active:Boolean,href:String,as:String},setup(d){const a=d,o=C(()=>a.active?"block w-full ps-3 pe-4 py-2 border-l-4 border-indigo-400 text-start text-base font-medium text-indigo-700 bg-indigo-50 focus:outline-none focus:text-indigo-800 focus:bg-indigo-100 focus:border-indigo-700 transition duration-150 ease-in-out":"block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:text-gray-800 focus:bg-gray-50 focus:border-gray-300 transition duration-150 ease-in-out");return(l,t)=>(s(),n("div",null,[d.as=="button"?(s(),n("button",{key:0,class:p([o.value,"w-full text-start"])},[f(l.$slots,"default")],2)):(s(),b(v(j),{key:1,href:d.href,class:p(o.value)},{default:r(()=>[f(l.$slots,"default")]),_:3},8,["href","class"]))]))}},de={class:"min-h-screen bg-gray-100"},ce={class:"bg-white border-b border-gray-100"},he={class:"max-w-7xl mx-auto px-4 sm:px-6 lg:px-8"},pe={class:"flex justify-between h-16"},fe={class:"flex"},ge={class:"shrink-0 flex items-center"},me={class:"hidden space-x-8 sm:-my-px sm:ms-10 sm:flex"},ve={class:"hidden sm:flex sm:items-center sm:ms-6"},_e={class:"ms-3 relative"},be={class:"inline-flex rounded-md"},ye={type:"button",class:"inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150"},we=e("svg",{class:"ms-2 -me-0.5 h-4 w-4",xmlns:"http://www.w3.org/2000/svg",fill:"none",viewBox:"0 0 24 24","stroke-width":"1.5",stroke:"currentColor"},[e("path",{"stroke-linecap":"round","stroke-linejoin":"round",d:"M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9"})],-1),ke={class:"w-60"},xe=e("div",{class:"block px-4 py-2 text-xs text-gray-400"}," Manage Team ",-1),$e=e("div",{class:"border-t border-gray-200"},null,-1),Ce=e("div",{class:"block px-4 py-2 text-xs text-gray-400"}," Switch Teams ",-1),je=["onSubmit"],Se={class:"flex items-center"},Me={key:0,class:"me-2 h-5 w-5 text-green-400",xmlns:"http://www.w3.org/2000/svg",fill:"none",viewBox:"0 0 24 24","stroke-width":"1.5",stroke:"currentColor"},Te=e("path",{"stroke-linecap":"round","stroke-linejoin":"round",d:"M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"},null,-1),Be=[Te],Le={class:"ms-3 relative"},Ne={key:0,class:"flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition"},ze=["src","alt"],Pe={key:1,class:"inline-flex rounded-md"},Ae={type:"button",class:"inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150"},De=e("svg",{class:"ms-2 -me-0.5 h-4 w-4",xmlns:"http://www.w3.org/2000/svg",fill:"none",viewBox:"0 0 24 24","stroke-width":"1.5",stroke:"currentColor"},[e("path",{"stroke-linecap":"round","stroke-linejoin":"round",d:"M19.5 8.25l-7.5 7.5-7.5-7.5"})],-1),Fe=e("div",{class:"block px-4 py-2 text-xs text-gray-400"}," Configuración ",-1),Ee=e("div",{class:"border-t border-gray-200"},null,-1),Ie={class:"-me-2 flex items-center sm:hidden"},Ve={class:"h-6 w-6",stroke:"currentColor",fill:"none",viewBox:"0 0 24 24"},Je={class:"pt-2 pb-3 space-y-1"},Oe={class:"pt-4 pb-1 border-t border-gray-200"},Re={class:"flex items-center px-4"},Ze={key:0,class:"shrink-0 me-3"},qe=["src","alt"],He={class:"font-medium text-base text-gray-800"},Ke={class:"font-medium text-sm text-gray-500"},Qe={class:"mt-3 space-y-1"},Ue=e("div",{class:"border-t border-gray-200"},null,-1),Ge=e("div",{class:"block px-4 py-2 text-xs text-gray-400"}," Manage Team ",-1),We=e("div",{class:"border-t border-gray-200"},null,-1),Xe=e("div",{class:"block px-4 py-2 text-xs text-gray-400"}," Switch Teams ",-1),Ye=["onSubmit"],et={class:"flex items-center"},tt={key:0,class:"me-2 h-5 w-5 text-green-400",xmlns:"http://www.w3.org/2000/svg",fill:"none",viewBox:"0 0 24 24","stroke-width":"1.5",stroke:"currentColor"},st=e("path",{"stroke-linecap":"round","stroke-linejoin":"round",d:"M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"},null,-1),ot=[st],rt={key:0,class:"bg-white shadow"},nt={class:"max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8"},lt={__name:"AppLayout",props:{title:String},setup(d){const a=$(!1),o=t=>{z.put(route("current-team.update"),{team_id:t.id},{preserveState:!1})},l=()=>{z.post(route("logout"))};return(t,_)=>(s(),n("div",null,[u(v(V),{title:d.title},null,8,["title"]),u(ae),e("div",de,[e("nav",ce,[e("div",he,[e("div",pe,[e("div",fe,[e("div",ge,[u(v(j),{href:t.route("dashboard")},{default:r(()=>[u(H,{class:"block h-14 w-auto"})]),_:1},8,["href"])]),e("div",me,[u(M,{href:t.route("dashboard"),active:t.route().current("dashboard")},{default:r(()=>[c(" Tablero principal ")]),_:1},8,["href","active"]),u(M,{href:t.route("corte"),active:t.route().current("corte")},{default:r(()=>[c(" Corte de caja ")]),_:1},8,["href","active"]),u(M,{href:t.route("inventario"),active:t.route().current("inventario")},{default:r(()=>[c(" Inventario ")]),_:1},8,["href","active"])])]),e("div",ve,[e("div",_e,[t.$page.props.jetstream.hasTeamFeatures?(s(),b(P,{key:0,align:"right",width:"60"},{trigger:r(()=>[e("span",be,[e("button",ye,[c(y(t.$page.props.auth.user.current_team.name)+" ",1),we])])]),content:r(()=>[e("div",ke,[xe,u(w,{href:t.route("teams.show",t.$page.props.auth.user.current_team)},{default:r(()=>[c(" Team Settings ")]),_:1},8,["href"]),t.$page.props.jetstream.canCreateTeams?(s(),b(w,{key:0,href:t.route("teams.create")},{default:r(()=>[c(" Create New Team ")]),_:1},8,["href"])):h("",!0),t.$page.props.auth.user.all_teams.length>1?(s(),n(k,{key:1},[$e,Ce,(s(!0),n(k,null,N(t.$page.props.auth.user.all_teams,i=>(s(),n("form",{key:i.id,onSubmit:x(g=>o(i),["prevent"])},[u(w,{as:"button"},{default:r(()=>[e("div",Se,[i.id==t.$page.props.auth.user.current_team_id?(s(),n("svg",Me,Be)):h("",!0),e("div",null,y(i.name),1)])]),_:2},1024)],40,je))),128))],64)):h("",!0)])]),_:1})):h("",!0)]),e("div",Le,[u(P,{align:"right",width:"48"},{trigger:r(()=>[t.$page.props.jetstream.managesProfilePhotos?(s(),n("button",Ne,[e("img",{class:"h-8 w-8 rounded-full object-cover",src:t.$page.props.auth.user.profile_photo_url,alt:t.$page.props.auth.user.name},null,8,ze)])):(s(),n("span",Pe,[e("button",Ae,[c(y(t.$page.props.auth.user.name)+" ",1),De])]))]),content:r(()=>[Fe,u(w,{href:t.route("profile.show")},{default:r(()=>[c(" Datos ")]),_:1},8,["href"]),t.$page.props.jetstream.hasApiFeatures?(s(),b(w,{key:0,href:t.route("api-tokens.index")},{default:r(()=>[c(" API Tokens ")]),_:1},8,["href"])):h("",!0),Ee,e("form",{onSubmit:x(l,["prevent"])},[u(w,{as:"button"},{default:r(()=>[c(" Cerrar Sesión ")]),_:1})],32)]),_:1})])]),e("div",Ie,[e("button",{class:"inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out",onClick:_[0]||(_[0]=i=>a.value=!a.value)},[(s(),n("svg",Ve,[e("path",{class:p({hidden:a.value,"inline-flex":!a.value}),"stroke-linecap":"round","stroke-linejoin":"round","stroke-width":"2",d:"M4 6h16M4 12h16M4 18h16"},null,2),e("path",{class:p({hidden:!a.value,"inline-flex":a.value}),"stroke-linecap":"round","stroke-linejoin":"round","stroke-width":"2",d:"M6 18L18 6M6 6l12 12"},null,2)]))])])])]),e("div",{class:p([{block:a.value,hidden:!a.value},"sm:hidden"])},[e("div",Je,[u(m,{href:t.route("dashboard"),active:t.route().current("dashboard")},{default:r(()=>[c(" Tablero principal ")]),_:1},8,["href","active"]),u(m,{href:t.route("corte"),active:t.route().current("corte")},{default:r(()=>[c(" Corte de caja ")]),_:1},8,["href","active"]),u(m,{href:t.route("inventario"),active:t.route().current("inventario")},{default:r(()=>[c(" Inventario ")]),_:1},8,["href","active"])]),e("div",Oe,[e("div",Re,[t.$page.props.jetstream.managesProfilePhotos?(s(),n("div",Ze,[e("img",{class:"h-10 w-10 rounded-full object-cover",src:t.$page.props.auth.user.profile_photo_url,alt:t.$page.props.auth.user.name},null,8,qe)])):h("",!0),e("div",null,[e("div",He,y(t.$page.props.auth.user.name),1),e("div",Ke,y(t.$page.props.auth.user.email),1)])]),e("div",Qe,[u(m,{href:t.route("profile.show"),active:t.route().current("profile.show")},{default:r(()=>[c(" Perfil ")]),_:1},8,["href","active"]),t.$page.props.jetstream.hasApiFeatures?(s(),b(m,{key:0,href:t.route("api-tokens.index"),active:t.route().current("api-tokens.index")},{default:r(()=>[c(" API Tokens ")]),_:1},8,["href","active"])):h("",!0),e("form",{method:"POST",onSubmit:x(l,["prevent"])},[u(m,{as:"button"},{default:r(()=>[c(" Cerrar sesión ")]),_:1})],32),t.$page.props.jetstream.hasTeamFeatures?(s(),n(k,{key:1},[Ue,Ge,u(m,{href:t.route("teams.show",t.$page.props.auth.user.current_team),active:t.route().current("teams.show")},{default:r(()=>[c(" Team Settings ")]),_:1},8,["href","active"]),t.$page.props.jetstream.canCreateTeams?(s(),b(m,{key:0,href:t.route("teams.create"),active:t.route().current("teams.create")},{default:r(()=>[c(" Create New Team ")]),_:1},8,["href","active"])):h("",!0),t.$page.props.auth.user.all_teams.length>1?(s(),n(k,{key:1},[We,Xe,(s(!0),n(k,null,N(t.$page.props.auth.user.all_teams,i=>(s(),n("form",{key:i.id,onSubmit:x(g=>o(i),["prevent"])},[u(m,{as:"button"},{default:r(()=>[e("div",et,[i.id==t.$page.props.auth.user.current_team_id?(s(),n("svg",tt,ot)):h("",!0),e("div",null,y(i.name),1)])]),_:2},1024)],40,Ye))),128))],64)):h("",!0)],64)):h("",!0)])])],2)]),t.$slots.header?(s(),n("header",rt,[e("div",nt,[f(t.$slots,"header")])])):h("",!0),e("main",null,[f(t.$slots,"default")])])]))}};export{lt as _};