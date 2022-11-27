<template>
    <div class="tab-pane active">
        <div class="panel-group">
            <div class="panel panel-default lgx-panel">
                <div class="panel-heading">
        
                    <form ref="form" @submit.prevent="validateForm" method="POST" enctype="multipart/form-data" class="lgx-contactform">
                        <!-- add tags directly from this page -->

                        
                  
                        <button type="button" class="btn lgx-btn btn-block"
                            :disabled="(Object.keys(this.is_publishable).length < 5 && event.publish == 0) ? true : false" 
                            :class="{ 'lgx-btn-danger': (event.publish == 1), 'lgx-btn-success': (event.publish != 1) }"
                            @click="publishEvent()"
                        >
                            <i v-if="!event.publish" class="fas fa-eye"></i> 
                            <i v-if="event.publish" class="fas fa-eye-slash"></i> 
                            {{ event.publish == 1 ? trans('em.unpublish') : trans('em.publish')}}
                        </button>
                    </form>
                
                </div>
            </div>
        </div>
        
    </div>
</template>

<script>
import _ from 'lodash';
import { mapState, mapMutations} from 'vuex';
import mixinsFilters from '../../mixins.js';


import TagComponent from '../../tags_manage/components/Tag.vue';

export default {

    props : [
        'organisers'
    ],

    mixins:[
        mixinsFilters
    ],

    components: {
        TagComponent,
    },

    data() {
        return {
            tags_ids         : [],
            tags_options     : [],
            tmp_tags_ids     : [],
            selected_tags    : [],
            is_publishable   : [],

            isLoading: false


        }
    },

    computed: {
        ...mapState( ['tags', 'event_id', 'organiser_id', 'event_step', 'event']),
    },

    methods: {
        ...mapMutations(['add', 'update']),

           // validate data on form submit
        validateForm(event) {
            this.$validator.validateAll().then((result) => {
                if (result) {
                    this.formSubmit(event);            
                }
            });
        },

        // show server validation errors
        serverValidate(serrors) {
            this.$validator.validateAll().then((result) => {
                this.$validator.errors.add(serrors);
            });
        },

        // submit form
        formSubmit(event) {
            // prepare form data for post request
            let post_url    = route('eventmie.myevents_store_event_tags');
            
            let post_data   = {
                'tags_ids'     : this.tags_ids,
                'event_id'     : this.event_id,
                'organiser_id' : this.organiser_id
            };
            
            // axios post request
            axios.post(post_url, post_data)
            .then(res => {

                if(res.data.status)
                {
                    this.showNotification('success', trans('em.event_save_success'));
                    // reload page   
                    setTimeout(function() {
                        location.reload(true);
                    }, 1000);
                }
            })
            .catch(error => {
                let serrors = Vue.helpers.axiosErrors(error);
                if (serrors.length) {
                    this.serverValidate(serrors);
                }
            });
        },

        
        

        // get selected tags in case of editing
        getSelectedtags() {
            let $this = this;
            axios.post(route('eventmie.selected_tags'),{
                event_id      : this.event_id,
                organiser_id  : this.organiser_id,
            })
            .then(res => {
                // fill data to global tags array
                this.selected_tags = res.data.selected_event_tags 

                
                // set mutiple tags for multiselect list
                if(this.selected_tags.length > 0)
                {
                    this.tmp_tags_ids = []; 
                    this.selected_tags.forEach(function (v, key) {
                        this.tmp_tags_ids.push({value : v.id, text : v.title+' ('+v.type+')' });
                    }.bind(this));
                }    
                
            })
            .catch(error => {
                Vue.helpers.axiosErrors(error);
            });
        },


        // update tags for submit
        updateTags(){
            
            this.tags_ids = '';
            
            //tags
            if(this.tmp_tags_ids.length > 0)
            {
                var count = this.tmp_tags_ids.length;
                this.tmp_tags_ids.forEach(function (value, key) {
                    this.tags_ids += value.value;

                    // add comma except last key
                    if(key < (count-1) )
                        this.tags_ids += ',';
                }.bind(this));
            }
            
        },

        // publish event
        publishEvent(){
            axios.post(route('eventmie.publish_myevent'),{
                event_id        : this.event_id,
                organiser_id    : this.organiser_id,
            })
            .then(res => {
                if(res.data.status)
                {
                    if(this.event.publish == 1)
                        this.showNotification('success', trans('em.event_unpublished'));
                    else
                        this.showNotification('success', trans('em.event_published'));
                    
                    // reload page   
                    setTimeout(function() {
                        location.reload(true);
                    }, 1000);
                }
            })
            .catch(error => {
                Vue.helpers.axiosErrors(error);
            });
        },

        limitText (count) {
            return trans('em.event')+count +trans('em.tags');
        },

        // get tags of organiser and tag searching
        searchTags: _.debounce(function(search) {  

            this.isLoading = true

            let post_url    = route('eventmie.search_tags');
            
            let post_data   = {
                'search'     : search,
                organiser_id : this.organiser_id, 
            };
            
            // axios post request
            axios.post(post_url, post_data)
            .then(res => {

                this.tags_options = [];
                // fill data to global tags array
                this.add({  
                    tags        : res.data.tags,
                });
                // set mutiple tags for multiselect list
                if(this.tags.length > 0)
                {
                    this.tags.forEach(function(v, key) {
                        this.tags_options.push({value : v.id, text : v.title+' ('+v.type+')' });
                    }.bind(this));
                    
                }
                
                this.isLoading = false;
            })
            .catch(error => {
                let serrors = Vue.helpers.axiosErrors(error);
                if (serrors.length) {
                    this.serverValidate(serrors);
                }
            });
        }, 1000),

        clearAll () {
            this.tmp_tags_ids = []
        },

        isDirty() {
            this.add({is_dirty: true});
        },
        isDirtyReset() {
            this.add({is_dirty: false});
        },

    },
    
    watch: {
        
        tmp_tags_ids : function() {
            this.updateTags();
        },
    },

    mounted(){
        this.isDirtyReset();
      // if user have no event_id then redirect to details page
        // if user have no event_id then redirect to details page
        let event_step  = this.eventStep();
        
        if(event_step)
        {
            var $this = this;
            this.getMyEvent().then(function (response){
                $this.searchTags(null);
                
                $this.getSelectedtags();  
                $this.is_publishable = $this.event.is_publishable ? JSON.parse($this.event.is_publishable) : [] ; 
            });

        }
        
        
    }

}
</script>