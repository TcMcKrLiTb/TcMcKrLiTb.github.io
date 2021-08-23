define(["./_chunks/vendor-fee82cbd"],(function(e){"use strict";var t={cs:{},de:{"Diagram imported":"Diagramm importiert","Loading media":"Lade Daten","New draw.io document…":"Neues draw.io Dokument...","The diagram could not be loaded…":"Das Diagramm konnte nicht geladen werden..."},es:{},fr:{},gl:{},it:{}};const i={name:"DrawIoEditor",data:()=>({loading:!0,filePath:"",fileExtension:"",isReadOnly:null,currentETag:null}),computed:{...e.mapGetters(["getToken"]),config(){const{url:e="https://embed.diagrams.net",theme:t="minimal",autosave:i=!1}=this.$store.state.apps.fileEditors.find((e=>"draw-io"===e.app)).config||{};return{url:e,theme:t,autosave:i?1:0}},iframeSource(){const t=e.queryString.stringify({embed:1,chrome:this.isReadOnly?0:1,picker:0,stealth:1,spin:1,proto:"json",ui:this.config.theme});return`${this.config.url}?${t}`}},created(){this.filePath=this.$route.params.filePath,this.fileExtension=this.filePath.split(".").pop(),this.checkPermissions(),window.addEventListener("message",(e=>{if(e.data.length>0){const t=JSON.parse(e.data);switch(t.event){case"init":"vsdx"===this.fileExtension?this.importVisio():this.load();break;case"autosave":case"save":this.save(t);break;case"exit":this.exit()}}}))},methods:{...e.mapActions(["showMessage"]),error(e){this.showMessage({title:this.$gettext("The diagram could not be loaded…"),desc:e,status:"danger"})},checkPermissions(){this.$client.files.fileInfo(this.filePath,["{http://owncloud.org/ns}permissions"]).then((e=>{this.isReadOnly=-1===e.fileInfo["{http://owncloud.org/ns}permissions"].indexOf("W"),this.loading=!1})).catch((e=>{this.error(e)}))},load(){this.$client.files.getFileContents(this.filePath,{resolveWithResponseObject:!0}).then((e=>{this.currentETag=e.headers.ETag,this.$refs.drawIoEditor.contentWindow.postMessage(JSON.stringify({action:"load",xml:e.body,autosave:this.config.autosave}),"*")})).catch((e=>{this.error(e)}))},importVisio(){const t=this.$client.files.getFileUrl(this.filePath),i=new Headers({Authorization:"Bearer "+this.getToken,"X-Requested-With":"XMLHttpRequest"});this.filePath+=`_${this.getTimestamp()}.drawio`,this.showMessage({title:this.$gettext("Diagram imported"),desc:(()=>this.$gettextInterpolate("The diagram will open as a new .drawio file: %{file}",{file:e.basename(this.filePath)},!0))()}),fetch(t,{headers:i}).then((e=>e.arrayBuffer())).then((e=>{const t=new Blob([e],{type:"application/vnd.visio"}),i=new FileReader;i.onloadend=()=>{this.$refs.drawIoEditor.contentWindow.postMessage(JSON.stringify({action:"load",xml:i.result,autosave:this.config.autosave}),"*")},i.readAsDataURL(t)})).catch((e=>{this.error(e)}))},save(e){this.$client.files.putFileContents(this.filePath,e.xml,{previousEntityTag:this.currentETag}).then((e=>{this.currentETag=e.ETag,this.$refs.drawIoEditor.contentWindow.postMessage(JSON.stringify({action:"status",modified:!1}),"*")})).catch((e=>{this.error(e)}))},exit(){window.close()},getTimestamp:()=>e.DateTime_1.local().toFormat("YYYYMMDD[T]HHmmss")}};var s=function(){var e=this,t=e.$createElement,i=e._self._c||t;return i("main",[e.loading?i("oc-spinner",{staticClass:"uk-position-center",attrs:{"aria-label":e.$gettext("Loading media"),size:"xlarge"}}):i("iframe",{ref:"drawIoEditor",attrs:{id:"drawio-editor",src:e.iframeSource,title:e.$gettext("Draw.io editor")}})],1)};s._withStripped=!0;return{appInfo:{name:"Draw.io",id:"draw-io",icon:"grid_on",extensions:[{extension:"drawio",newTab:!0,routeName:"draw-io-edit",newFileMenu:{menuTitle:e=>e("New draw.io document…")},routes:["files-personal","files-favorites","files-shared-with-others","files-shared-with-me","files-public-list"]},{extension:"vsdx",newTab:!0,routeName:"draw-io-edit",routes:["files-personal","files-favorites","files-shared-with-others","files-shared-with-me","files-public-list"]}]},routes:[{name:"edit",path:"/edit/:filePath",components:{fullscreen:e.normalizeComponent({render:s,staticRenderFns:[]},undefined,i,"data-v-04ff3b56",false,undefined,!1,void 0,void 0,void 0)},meta:{hideHeadbar:!0}}],translations:t}}));
