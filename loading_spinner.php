<!-- Loading spinner styles -->
<style>
#loading-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: white;
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
    background-color: rgb(0, 7, 110, 0.9);
}

/* HTML: <div class="loader"></div> */
.loader {
  width: 80px;
  height: 80px;
  border-radius: 50%;
  border: 8px solid #d1914b;
  box-sizing: border-box;
  --c:no-repeat radial-gradient(farthest-side, #d64123 94%,#0000);
  --b:no-repeat radial-gradient(farthest-side, #000 94%,#0000);
  background:
    var(--c) 11px 15px,
    var(--b) 6px 15px,    
    var(--c) 35px 23px,
    var(--b) 29px 15px,    
    var(--c) 11px 46px,
    var(--b) 11px 34px,    
    var(--c) 36px 0px,
    var(--b) 50px 31px,
    var(--c) 47px 43px,
    var(--b) 31px 48px,    
    #f6d353; 
  background-size: 15px 15px,6px 6px;
  animation: l4 3s infinite;
}
@keyframes l4 {
  0%     {-webkit-mask:conic-gradient(#0000 0     ,#000 0)}
  16.67% {-webkit-mask:conic-gradient(#0000 60deg ,#000 0)}
  33.33% {-webkit-mask:conic-gradient(#0000 120deg,#000 0)}
  50%    {-webkit-mask:conic-gradient(#0000 180deg,#000 0)}
  66.67% {-webkit-mask:conic-gradient(#0000 240deg,#000 0)}
  83.33% {-webkit-mask:conic-gradient(#0000 300deg,#000 0)}
  100%   {-webkit-mask:conic-gradient(#0000 360deg,#000 0)}
}
</style>

<!-- Loading overlay HTML -->
<div id="loading-overlay">
    <div class="loader">
        <div class="egg"></div>
    </div>
</div>

<!-- Loading spinner script -->
<script>
    window.addEventListener('load', function() {
        setTimeout(function() {
            document.getElementById('loading-overlay').style.display = 'none';
        }, 100);
    });
</script> 