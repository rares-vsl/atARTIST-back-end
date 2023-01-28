<script setup>
import { onMounted, ref } from 'vue'

const t = ref(null)
onMounted(() => {
    window.addEventListener("message", iframeEvent, false);
})

function iframeEvent(event){
    //if(event.origin !== 'https://www.xyz.com') return;
    //t.value = event.data. + 'b'
    try{
        t.value = event.data.data.age
    } catch{

    }
}

//console.log(myid.value.getAttribute('id'))
//myid.value.contentWindow.postMessage(message, '*')

//frameEle.contentWindow.postMessage(message, '*');
//localStorage.setItem('t', 'ciao')


</script>
<template>
    <div>
        <p>{{ t }}</p>
        <iframe src="http://localhost:5175/"
                name="thumbnails"
                frameborder="0"
                style="width: 100%;
  height: 150px;">
        </iframe>
    </div>
</template>