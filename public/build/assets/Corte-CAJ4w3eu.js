import{Q as W,d as r,l as L,T as A,o as s,c as Q,w as V,a as e,e as l,t as o,g as p,u as b,m as w,v as z,p as j,f as m,F as v,h,q as G}from"./app-C8CjfH1x.js";import{_ as H}from"./AppLayout-DjOK1K87.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";const J={class:"flex justify-between flex-col md:flex-row"},K={key:0},R={class:"text-xl font-bold"},X={key:1},Y=e("h1",{class:"lg:text-2xl sm:text-xl font-bold"},"Corte de caja de sucursales",-1),Z={class:"text-lg"},ee={class:"font-bold md:text-2xl px-2 py-1 rounded-lg"},te={class:"text-lg"},se={class:"font-bold md:text-2xl px-2 py-1 rounded-lg"},le={key:0},oe={class:"text-lg my-3"},ae={class:"font-bold text-white md:text-2xl bg-green-500 px-2 py-1 rounded-lg"},de={class:"text-lg my-3"},ie={class:"font-bold text-white md:text-2xl bg-green-500 px-2 py-1 rounded-lg"},ne={class:"text-lg my-3"},re={class:"font-bold text-white md:text-2xl bg-green-500 px-2 py-1 rounded-lg"},ce={class:"text-lg my-3"},ue={class:"font-bold text-white md:text-2xl bg-green-500 px-2 py-1 rounded-lg"},_e={class:"text-lg"},pe={class:"font-bold text-white md:text-2xl bg-teal-400 px-2 py-1 rounded-lg"},ve={key:1,class:"flex flex-col items-center"},he={class:"flex flex-col md:flex-row items-center gap-4"},me={class:"w-full gap-2 flex flex-col items-center"},fe=e("label",{for:"filter",class:"font-bold"},"Filtrar por:",-1),xe={class:"flex gap-2"},ge=e("option",{value:"day"},"Día",-1),be=e("option",{value:"week"},"Semana",-1),ye=e("option",{value:"month"},"Mes",-1),ke=[ge,be,ye],we={key:0,class:"text-red-500 font-bold mt-2"},Te={class:"py-4"},De={class:"max-w mx-auto sm:px-2 lg:px-4"},Fe={class:"overflow-hidden sm:rounded-lg"},$e={key:0},je={class:"bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4"},Be=e("h2",{class:"text-2xl text-gray-500 font-bold mb-5"},"Pedidos atendidos de hoy",-1),Me={class:"grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4"},Se={class:"flex justify-between items-center"},Ee={key:0},Ne=e("p",{class:"font-bold mt-2"},"Marquesitas:",-1),Oe={class:"list-disc pl-5"},Ce={class:"list-disc pl-5"},Ve={key:0},qe={key:1},Ue=e("li",null,"Sencillas.",-1),Ie=[Ue],Pe={key:1},We=e("p",{class:"font-bold mt-2"},"Bebidas:",-1),Le={class:"list-disc pl-5"},Ae={key:1,class:"bg-white shadow-md rounded-xl px-8 pt-6 pb-8 mb-4"},Qe={class:"grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3"},ze={class:"text-center font-bold text-xl"},Ge={class:"mt-4"},He={class:"font-bold"},Je={key:0},Ke=e("p",{class:"font-bold mt-2"},"Marquesitas:",-1),Re={class:"list-disc pl-5"},Xe={class:"list-disc pl-5"},Ye={key:0},Ze={key:1},et=e("li",null,"Sencillas.",-1),tt=[et],st={key:1},lt=e("p",{class:"font-bold mt-2"},"Bebidas:",-1),ot={class:"list-disc pl-5"},rt={__name:"Corte",setup(at){const{props:i}=W(),B=r(i.totalEfectivo||0),M=r(i.totalTarjeta||0),S=r(i.totalTransferencia||0),E=r(i.totalBruto||0),T=r(i.ordens||[]),D=r(i.numeroDeOrdenes||0),F=r(i.hoy||""),N=r(i.sucursal||0),k=r(null),q=r(null),_=r(i.selectedFilter||"day"),f=r(i.selectedDate||""),x=r(i.selectedWeek||""),g=r(i.selectedMonth||""),O=r(i.numeroDeMarquesitas||0),U=L(()=>{if(N.value>0)return[];const u=T.value.reduce((t,a)=>{t[a.sucursal_id]||(t[a.sucursal_id]={id:a.sucursal_id,totalEfectivo:0,totalTarjeta:0,totalTransferencia:0,totalBruto:0,numeroDeOrdenes:0,ordens:[]});const d=parseFloat(a.total);if(!isNaN(d))switch(t[a.sucursal_id].totalBruto+=d,t[a.sucursal_id].numeroDeOrdenes+=1,t[a.sucursal_id].ordens.push(a),a.metodo){case"Efectivo":t[a.sucursal_id].totalEfectivo+=d;break;case"Tarjeta":t[a.sucursal_id].totalTarjeta+=d;break;case"Transferencia":t[a.sucursal_id].totalTransferencia+=d;break}return t},{});return Object.values(u).map(t=>(t.ordens.sort((a,d)=>a.id-d.id),t))}),$=A({filter:_.value,value:g.value||x.value||f.value}),I=()=>{if(!f.value&&!x.value&&!g.value){k.value="Debe seleccionar una fecha.";return}let u="";switch(_.value){case"day":u=f.value;break;case"week":u=x.value;break;case"month":u=g.value;break}$.filter=_.value,$.value=u,$.get("/datos-filtrados",{onSuccess:n=>{B.value=n.props.totalEfectivo,M.value=n.props.totalTarjeta,S.value=n.props.totalTransferencia,E.value=n.props.totalBruto,T.value=n.props.ordens,O.value=n.props.numeroDeMarquesitas,D.value=n.props.numeroDeOrdenes,k.value="Debe seleccionar una fecha.",q.value="Filtrado por"},onError:n=>{console.error("Error al obtener datos filtrados:",n)}})},P=()=>{_.value="day",f.value="",x.value="",g.value="",contador.value=0,G.get("/corte")};return(u,n)=>(s(),Q(H,{title:"Tablero"},{header:V(()=>[e("div",J,[e("div",null,[u.$page.props.auth.user.sucursal_id>0?(s(),l("div",K,[e("h1",R,"Corte de caja de sucursal "+o(N.value),1),e("p",null,"Corte del día "+o(F.value.split("T")[0].split("-")[2]+"/"+F.value.split("T")[0].split("-")[1]+"/"+F.value.split("T")[0].split("-")[0]),1)])):(s(),l("div",X,[Y,e("p",Z,[p("Número de órdenes: "),e("span",ee,o(D.value),1)])])),e("p",te,[p("Número de marquesitas: "),e("span",se,o(O.value),1)]),e("span",null,o(b(i).selectedFilter==="day"?"Filtro por día: "+b(i).selectedDate.split("T")[0]:b(i).selectedFilter==="week"?"Filtro por semana: "+b(i).selectedWeek:b(i).selectedFilter==="month"?"Filtro por mes: "+b(i).selectedMonth.split("-").reverse().join("/"):""),1)]),u.$page.props.auth.user.sucursal_id>0?(s(),l("div",le,[e("p",oe,[p("Total en efectivo: "),e("span",ae,"$"+o(B.value),1)]),e("p",de,[p("Total con tarjeta: "),e("span",ie,"$"+o(M.value),1)]),e("p",ne,[p("Total por transferencia: "),e("span",re,"$"+o(S.value),1)]),e("p",ce,[p("Total bruto: "),e("span",ue,"$"+o(E.value),1)]),e("p",_e,[p("Número de órdenes: "),e("span",pe,o(D.value),1)])])):(s(),l("div",ve,[e("div",he,[e("div",me,[fe,e("div",xe,[w(e("select",{class:"ml-1 py-0 rounded",id:"filter","onUpdate:modelValue":n[0]||(n[0]=t=>_.value=t)},ke,512),[[z,_.value]]),_.value==="day"?w((s(),l("input",{key:0,class:"w-fit h-fit p-1 rounded",id:"valueSelect",type:"date","onUpdate:modelValue":n[1]||(n[1]=t=>f.value=t)},null,512)),[[j,f.value]]):m("",!0),_.value==="week"?w((s(),l("input",{key:1,class:"w-fit h-fit p-1 rounded",id:"valueSelect",type:"week","onUpdate:modelValue":n[2]||(n[2]=t=>x.value=t)},null,512)),[[j,x.value]]):m("",!0),_.value==="month"?w((s(),l("input",{key:2,class:"w-fit h-fit p-1 rounded",id:"valueSelect",type:"month","onUpdate:modelValue":n[3]||(n[3]=t=>g.value=t)},null,512)),[[j,g.value]]):m("",!0)]),e("div",{class:"flex gap-1"},[e("button",{class:"text-sm rounded-lg shadow-lg disabled px-3 py-2 bg-blue-500 text-white hover:bg-blue-600",onClick:I},"Aplicar Filtro"),e("button",{class:"text-sm rounded-lg shadow-lg px-3 py-2 bg-gray-500 text-white hover:bg-gray-600",onClick:P}," Limpiar Filtro ")])])]),k.value?(s(),l("div",we,o(k.value),1)):m("",!0)]))])]),default:V(()=>[e("div",Te,[e("div",De,[e("div",Fe,[u.$page.props.auth.user.sucursal_id>0?(s(),l("div",$e,[e("div",je,[Be,e("div",Me,[(s(!0),l(v,null,h(T.value,(t,a)=>(s(),l("div",{key:t.id,class:"mb-4 shadow-xl bg-gray-100 p-4 rounded"},[e("div",Se,[e("p",null,"No. "+o(a+1)+" - "+o(t.nombre_comprador)+" - Total: $"+o(t.total),1)]),t.marquesitas&&t.marquesitas.length?(s(),l("div",Ee,[Ne,e("ul",Oe,[(s(!0),l(v,null,h(t.marquesitas,d=>{var c;return s(),l("li",{key:d.id},[p(" Precio: $"+o(d.precio_marquesita)+" ("+o(d.cantidad)+") ",1),e("ul",Ce,[((c=d.ingredientes)==null?void 0:c.length)>0?(s(),l("div",Ve,[(s(!0),l(v,null,h(d.ingredientes,y=>(s(),l("li",{key:y.id}," Ingrediente: "+o(y.nombre),1))),128))])):(s(),l("div",qe,Ie))])])}),128))])])):m("",!0),t.bebidas&&t.bebidas.length?(s(),l("div",Pe,[We,e("ul",Le,[(s(!0),l(v,null,h(t.bebidas,d=>(s(),l("li",{key:d.id},o(d.nombre)+" - $"+o(d.precio)+" ("+o(d.cantidad)+") ",1))),128))])])):m("",!0)]))),128))])])])):(s(),l("div",Ae,[e("div",Qe,[(s(!0),l(v,null,h(U.value,t=>(s(),l("div",{key:t.id,class:"col-span-1 border rounded-2xl p-4"},[e("h1",ze,"Sucursal "+o(t.id),1),e("p",null,"Total en efectivo: $"+o(t.totalEfectivo),1),e("p",null,"Total con tarjeta: $"+o(t.totalTarjeta),1),e("p",null,"Total por transferencia: $"+o(t.totalTransferencia),1),e("p",null,"Total bruto: $"+o(t.totalBruto),1),e("p",null,"Número de órdenes: "+o(t.numeroDeOrdenes),1),e("div",Ge,[(s(!0),l(v,null,h(t.ordens,(a,d)=>(s(),l("div",{key:a.id,class:"mb-2"},[e("p",He,">>ID"+o(t.id)+"-"+o(d+1)+" - "+o(a.nombre_comprador)+" - Total: $"+o(a.total+"<<"),1),a.marquesitas&&a.marquesitas.length?(s(),l("div",Je,[Ke,e("ul",Re,[(s(!0),l(v,null,h(a.marquesitas,c=>{var y;return s(),l("li",{key:c.id},[p(" Precio: $"+o(c.precio_marquesita)+" ("+o(c.cantidad)+") ",1),e("ul",Xe,[((y=c.ingredientes)==null?void 0:y.length)>0?(s(),l("div",Ye,[(s(!0),l(v,null,h(c.ingredientes,C=>(s(),l("li",{key:C.id}," Ingrediente: "+o(C.nombre),1))),128))])):(s(),l("div",Ze,tt))])])}),128))])])):m("",!0),a.bebidas&&a.bebidas.length?(s(),l("div",st,[lt,e("ul",ot,[(s(!0),l(v,null,h(a.bebidas,c=>(s(),l("li",{key:c.id},o(c.nombre)+" - $"+o(c.precio)+" ("+o(c.cantidad)+") ",1))),128))])])):m("",!0)]))),128))])]))),128))])]))])])])]),_:1}))}};export{rt as default};