<template>
    <textarea
        :name="name"
        :placeholder="placeholder"
        :value="value"
        @input="$emit('input',$event.target.value)">
      </textarea>
</template>

<script>
    export default {

        props:{
            name:{
               type: String,
               required: true,
            },
            placeholder:{
              type: String,
              default: "",
            },
            value:{
              type: String,
              default: "",
            },
        },
    }
</script>
<style scoped>
    textarea {
        width: 100%;
        border-radius: 4px;
        border: 1px solid brown;
        font-size: 17px;
        display: block;
        box-sizing: border-box;
        padding: 10px 15px;
        border-radius: 13px;
        font-weight: 100;
        letter-spacing: 0.01em;
        position: relative;
        z-index: 1;
    }
</style>
