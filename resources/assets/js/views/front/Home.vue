<template>
    <section class="section section-hero-area container">
            <ul v-if="isLogged" class="tab-list">
                <li class="tab-button" :class="{'active-tab': tabFlag === 'all'}" @click="changeTab('all')" >Przepisy</li>
                <li class="tab-button" :class="{'active-tab': tabFlag === 'liked'}" @click="changeTab('liked')">Ulubione przepisy</li>
                <li class="tab-button" :class="{'active-tab': tabFlag === 'my'}" @click="changeTab('my')">Twoje przepisy</li>
            </ul>
          <hr class="sep-line">
          <div class="section section-of-recepies">
            <div class="row">
              <div class="col-lg-6">
                <input type="text" class="form-control" placeholder="Wyszukaj po nazwie" v-model="searchRecepie">
              </div>
              <div class="col-lg-4">
                  <v-select class="select-background" :options="kategorie" :onChange="onChange" placeholder="Wybierz kategorię">
                  </v-select>
              </div>
              <div class="col-lg-2">
                  <button type="button" class="btn btn-search" @click="sort"><i class="fa fa-search"></i> Szukaj</button>
              </div>
            </div>
            <ul v-if="strona.length < 1" class="list-of-rcepies">
                <li class="no-items">Nie znaleziono przepisów</li>
            </ul>
            <ul v-else class="list-of-rcepies">
              <li class="list-of-recepies-item"
                  v-for="(przepis, index) in strona" v-if="index >= listOfRecepies.listStart && index <= listOfRecepies.listStop">
                  <span class="nazwa-potrawy">{{ przepis.potrawa }}</span>
                  <span class="autor">{{ przepis.autor }}</span>
                  <span class="kategoria">{{ przepis.kategoria }}</span>
                  <span class="ocena">{{ przepis.ocena }}</span></li>
            </ul>
            <div>
              <ul v-if="listOfRecepies.lastPage !== 1" class="list-of-pages">
                <li v-if="listOfRecepies.active !== 1" @click="switchPageOfRecepies(listOfRecepies.active - 1)"><<</li>
                <li v-for="listaStron in listOfRecepies.lastPage" @click="switchPageOfRecepies(listaStron)">{{ listaStron }}</li>
                <li v-if="listOfRecepies.active !== listOfRecepies.lastPage" @click="switchPageOfRecepies(listOfRecepies.active + 1)">>></li>
              </ul>
            </div>
        </div>
    </section>
</template>

<script type="text/javascript">
  export default{
    props:['kategorie','isLogged'],
    data() {
      return{
        przepisy: [],
        strona: [],
        listOfRecepies: {
          active: 1,
          lastPage: 0,
          listItems: 7,
          listStart: 0,
          listStop: 6,
        },
        category: null,
        searchRecepie: "",
        tabFlag: "all",
        user: null
      }
    },
    beforeMount() {
      var self = this;

      axios.get('/api/v1/recipes')
      .then(function (response) {
        for(var i = 0; i < response.data.length; i++) {
          var data = response.data[i];

          self.przepisy.push({
            id: data.recipe.id,
            potrawa: data.recipe.name,
            kategoria: data.category.name,
            autor: data.user.first_name +" "+ data.user.last_name,
            ocena: data.rate.value
          });
        }
      })
      .catch(function (error) {
        toastr['error']('Nastąpił jakiś błąd', 'Error');
      });

      for(var i=0; i<this.przepisy.length; i++) {
         this.strona.push(this.przepisy[i]);
      }
      this.listOfRecepies.lastPage = Math.floor((this.strona.length)/this.listOfRecepies.listItems) + 1;
    },
    methods: {
      changeTab(value) {
          this.tabFlag = value;
      },
      switchPageOfRecepies(page) {
          this.listOfRecepies.active = page;
          this.listOfRecepies.listStart = (page-1)*this.listOfRecepies.listItems;
          this.listOfRecepies.listStop = (page)*this.listOfRecepies.listItems - 1;
      },
      onChange(value){
        this.category = value;
      },
      sort(){

        this.strona = [];

        for(var i=0; i<this.przepisy.length; i++) {
           this.strona.push(this.przepisy[i]);
        }

        if(this.tabFlag === "moje"){
            var bufor = [];

            for(var i=0; i<this.strona.length; i++) {
                if(this.strona[i].autor === this.user) {
                    bufor.push(this.strona[i]);
                }
            }
            this.strona = [];
            for(var i=0; i<bufor.length; i++) {
               this.strona[i] = bufor[i];
            }
        }

        if(this.category){
            var bufor = [];

            for(var i=0; i<this.strona.length; i++) {
                if(this.strona[i].kategoria === this.category) {
                    bufor.push(this.strona[i]);
                }
            }
            this.strona = [];
            for(var i=0; i<bufor.length; i++) {
               this.strona[i] = bufor[i];
            }
        }

        if(this.searchRecepie){
            var bufor = [];

            for(var i=0; i<this.strona.length; i++) {
                if(this.strona[i].potrawa.includes(this.searchRecepie)) {
                    bufor.push(this.strona[i]);;
                }
            }
            this.strona = [];
            for(var i=0; i<bufor.length; i++) {
               this.strona[i] = bufor[i];
            }
        }

        this.listOfRecepies.active = 1;
        this.listOfRecepies.listStart = 0;
        this.listOfRecepies.listStop = 6;
        this.listOfRecepies.lastPage = Math.floor((this.strona.length)/this.listOfRecepies.listItems) + 1;
     },
   },
}
</script>
