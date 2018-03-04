<template>
  <div>
      <ul v-if="page.length < 1"
          class="list-of-rcepies">
          <li class="no-items">
              Nie znaleziono przepisów
          </li>
      </ul>
      <ul v-else class="list-of-rcepies">
          <li class="list-of-recepies-item"
              v-for="(recepie, index) in page"
              v-if="index >= start && index <= stop"
              @click="getRecepieData(recepie)">
              <router-link to="/recepie">
                <div>
                    <span class="recepie-name">{{ recepie.recepieName }}</span>
                    <span class="autor">{{ recepie.autor }}</span>
                    <span class="category">{{ recepie.category }}</span>
                    <span class="rank">{{ recepie.rank }}</span>
                </div>
              </router-link>
          </li>
      </ul>
  </div>
</template>

<script>
export default {
    props: {
        page:{
            type: Array,
            default: [],
        },
        start:{
            type: Number,
            default: 0,
        },
        stop:{
          type: Number,
          default: 7,
        },
    },
    methods:{
        getRecepieData(recepie) {
            console.log(recepie);
        },
    }
}
</script>
