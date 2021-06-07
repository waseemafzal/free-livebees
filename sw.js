self.addEventListener("install", e=>{
  e.waitUntil(
   caches.open("static").then( cache=>{
return cache.addAll(["./"]);

   })
 );

});
self.addEventListener("fetch",e=> {
 //start
 //console.log(e.request.url);
//ready for install
e.respondWith(
 caches.match(e.request).then(response =>{


 return response || fetch(e.request);
 })
	);
});



   