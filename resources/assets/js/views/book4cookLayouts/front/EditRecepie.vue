<template>
    <section class="section register-box section-of-recepies">
        <form id="newRecipeForm"
              method="post">
            <div class="row add-recepie-container">
                <div class="col-lg-12">
                    <div class="row">
                        <h4 class="h4-new-recepie">Nazwa przepisu:</h4>
                        <div :class="{'form-group col-lg-6': true, 'has-danger': errors.has('name') }">
                            <input-text type="text"
                                   class="form-control"
                                   name="name"
                                   v-model="recipeData.name"
                                   v-validate="'required'"
                                   placeholder="Mój przepis">
                            </input-text>
                        </div>
                        <span v-show="errors.has('name')"
                              class="help">
                              {{ errors.first('name') }}
                        </span>
                    </div>
                    <div class="row">
                        <h4 class="h4-new-recepie">Kategoria:</h4>
                        <div :class="{'form-group col-lg-6': true, 'has-danger': errors.has('category') }">
                            <v-select class="select-background"
                                      name="category"
                                      v-model="category"
                                      v-validate="'required'"
                                      :options="recepieCategories"
                                      placeholder='Wybierz kategorię'>
                            </v-select>
                        </div>
                        <span v-show="errors.has('category')"
                              class="help">
                              {{ errors.first('category') }}
                        </span>
                    </div>
                    <div class="row">
                        <h4 class="h4-new-recepie">Tagi:</h4>
                        <div class="col">
                            <v-select class="select-background"
                                      name="tags"
                                      v-model="tagsIn"
                                      :options="recepieTags"
                                      placeholder='Wybierz tag'
                                      multiple>
                            </v-select>
                        </div>
                        <div v-show="tagsIn.length < 1"
                             class="help">
                             At least 1 tag is required!
                        </div>
                    </div>
                    <div class="row">
                        <h4>Składniki:</h4>
                        <div class="col-lg-12 description-recepie">
                            <div :class="{'form-group': true, 'has-danger': errors.has('ingredients') }">
                                <input-text-area class="form-control text-fieald"
                                                 name="ingredients"
                                                 v-model="recipeData.ingredients"
                                                 v-validate="'required'"
                                                 placeholder="Wymień składniki">
                               </input-text-area>
                               <div v-show="errors.has('ingredients')"
                                    class="help">
                                    {{ errors.first('ingredients') }}
                               </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <h4>Przygotowanie:</h4>
                        <div class="col-lg-12 description-recepie">
                            <div :class="{'form-group': true, 'has-danger': errors.has('description') }">
                                <input-text-area class="form-control text-fieald"
                                                 name="description"
                                                 v-model="recipeData.description"
                                                 v-validate="'required'"
                                                 placeholder="Opisz przygotowanie potrawy">
                                </input-text-area>
                                <div v-show="errors.has('description')"
                                     class="help">
                                     {{ errors.first('description') }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row-sep">
                        <div class="col-lg-12">
                            <div class="col-lg-6 offset-lg-3">
                                <button class="btn btn-theme btn-full"
                                        type="button"
                                        @click="validateBeforeSubmit">
                                        Zapisz
                                </button>
                                <router-link class="btn btn-theme btn-full"
                                             to="/#">
                                             Strona głowna
                                </router-link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>
</template>

<script>

import InputText from '../inputs/InputText.vue';
import InputTextArea from '../inputs/InputTextArea.vue';
import Ls from '../../../services/ls';

export default {
    props: {
        categories: {
            type: Array,
            required: true,
        },
        tags: {
            type: Array,
            required: true,
        },

    },
    components: {
        InputText,
        InputTextArea,
    },
    data() {
        return {
            tagsIn: [],
            category: null,
            recipeData: {
                name: "",
                subcategory_id: "",
                ingredients: "",
                description: "",
                tags:[],
            }
        }
    },
    computed:{
      recepieCategories(){
        let categoriesTab = [];

        for(let i = 0; i<this.categories.length; i++){
          const label =  this.categories[i].name;
          const value =  this.categories[i].id;

          categoriesTab.push({label,value});
        }
        return categoriesTab;
      },
      recepieTags(){
        let tagsTab = [{}];

        for(let i = 0; i < this.tags.length; i++){
            const label =  this.tags[i].name;
            const value =  this.tags[i].id;

            tagsTab.push({label,value});
        }

        return tagsTab;
      },
    },
    created() {
        let self = this;
        if(!Ls.get('auth.token')) {
           this.$router.push('/#');
        }
    },
    methods: {
       validateBeforeSubmit(e){
            var self = this;

             this.recipeData.subcategory_id = this.category.value;

            for(let i = 0; i<self.tagsIn.length; i++){
                self.recipeData.tags.push(self.tagsIn[i].value);
            }

            self.recipeData.tags.sort(function(a, b){return a-b});

            console.log(this.recipeData);


            this.$validator.validateAll().then(result => {
                if(self.recipeData.tags.length < 1) result = false;
                if (!result){
                    toastr['error']('Wypełnij wymagane pola', 'Błąd tworzenia przepisu');
                }else{
                    axios.post('/api/v1/recipes', self.recipeData).then(response => {
                      toastr['success']('Dodano przepis!', 'Sukces');
                      //$router.push('/#');
                    }).catch(error => {
                      if (error.response.status == 401) {
                        toastr['error']('Popraw błędy!', 'Błąd walidacji');
                      } else {
                        // Something happened in setting up the request that triggered an Error
                        console.log('Error', error.message);
                      }
                    });

                }
            });
        },
    },
}
</script>
