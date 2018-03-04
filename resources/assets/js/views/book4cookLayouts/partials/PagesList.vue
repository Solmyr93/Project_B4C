<template>
  <div>
    <ul v-if="stop !== 1"
        class="list-of-pages">
        <li v-if="active >= 3"
            @click="switchPageOfRecepies(1)">
            <i class="fa fa-arrow-left"></i>
            <i class="fa fa-arrow-left"></i>
        </li>
        <span v-if="active >= 3">...</span>
        <li v-if="active !== 1"
            @click="switchPageOfRecepies(active - 1)">
            <i class="fa fa-arrow-left"></i>
        </li>
        <li v-for="list in stop"
            v-if="list >= active - 2 &&  list <= active + 2"
            :class="{'active-item': list === active,
                     'list-displayed': list >= active - 2 &&  list <= active + 2}"
            @click="switchPageOfRecepies(list)">
            <b>{{ list }}</b>
        </li>
        <li v-if="active !== stop && stop !== 0"
            @click="switchPageOfRecepies(active + 1)">
            <i class="fa fa-arrow-right"></i>
        </li>
        <span v-if="active <= stop-2">...</span>
        <li v-if="active <= stop-2"
            @click="switchPageOfRecepies(stop)">
            <i class="fa fa-arrow-right"></i>
            <i class="fa fa-arrow-right"></i>
        </li>
    </ul>
  </div>
</template>

<script scoped>
export default {
  props: {
      active:{
          type: Number,
          default: 1,
      },
      stop:{
        type: Number,
        default: 0,
      },
      items:{
        type: Number,
        required: true,
      },
  },
  data(){
    return{
        listStart: null,
        listStop: null,
        listActive: null,
    }
  },
  methods: {
      switchPageOfRecepies(page) {

          this.listActive = page;
          this.listStart = (page-1)*this.items;
          this.listStop = (page)*this.items - 1;

          this.$emit('changeActive', this.listActive);
          this.$emit('changeStart', this.listStart);
          this.$emit('changeStop', this.listStop);
      },
  },
}
</script>
<style>
  .list-of-pages .active-item {
      background-color: brown;
      color: white;
  }
  .list-of-pages .list-displayed{
      border-radius: 0px;
      border: 1px solid black;
      margin: 0 4px;
  }

</style>
