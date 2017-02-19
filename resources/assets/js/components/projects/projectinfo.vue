<template lang="html">
    <div>
      <div class="modal fade" tabindex="-1" role="dialog" id="newStatusModal">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Add a new status</h4>
          </div>
          <div class="modal-body">
            <form v-on:submit.prevent="createStatus" method="post" enctype="multipart/form-data">
              <div style="display:none" class="Image-input__image-wrapper">
            <i v-show="! imageSrc" class="icon fa fa-picture-o"></i>
            <img v-show="imageSrc" class="Image-input__image" :src="imageSrc">
        </div>

        <div class="Image-input__input-wrapper">
            Choose
            <input @change="previewThumbnail" class="Image-input__input" name="thumbnail" type="file">
        </div>
                <div v-bind:class="{'form-group': true, 'has-error': errors.description}">
                    <label>Status Description:</label>
                    <input type="text" class="form-control" v-model="newStatus.description">
                    <span class="help-block" v-for="error in errors.description">{{ error }}</span>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Save New Status</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                </div>
            </form>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /. New Status modal -->

    <div class="modal fade" tabindex="-1" role="dialog" id="updateStatusModal">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Add a new status</h4>
        </div>
        <div class="modal-body">
          <form v-on:submit.prevent="updateStatus" method="post">
            <input type="hidden" name="_method" value="PATCH">
              <div v-bind:class="{'form-group': true, 'has-error': errors.description}">
                  <label>Status Description:</label>
                  <input type="text" v-model="editStatus.description" class="form-control">
                  <span class="help-block" v-for="error in errors.description">{{ error }}</span>
              </div>
              <div class="form-group">
                  <button type="submit" class="btn btn-primary">Save New Status</button>
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
              </div>
          </form>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /. New Status modal -->


    <button  v-if="permissions == 'true'" type="button" data-toggle="modal" data-target="#newStatusModal" class="btn btn-primary">New Status</button>

    <div class="status_grid">
        <div class="status_block" v-for="status in statuses" 
            v-on:update-user="fetchStatuses">
            <div class="status_image">
              <img :alt="status.description" :src="status.image" />
            </div>
            <span class="status_info">{{status.description}}<br/>{{status.created_at}}</span>
            <button  v-if="permissions == 'true'" type="button" class="btn btn-warning" v-on:click="fetchStatus(status)">
              Edit
            </button>
            <button  v-if="permissions == 'true'" type="button" class="btn btn-danger" v-on:click="deleteStatus(status)">
              Delete
            </button>
        </div>
        <div class="clearfix"></div>
      </div>

    </div>
</template>

<script>
export default {
    props: {
      userslug: '',
      projectslug: '',
      projectid: '',
      permissions: {
        default: false
      }
    },
    data(){
        return {
            statuses: [],
            errors: [],
            newStatus:{
              project_id: this.projectid,
              description: '',
              image: '',
            },
            imageSrc: '',
            editStatus:{
              id: '',
              description: '',
              image: '',
            },
        }
    },
    created(){
        this.fetchStatuses();
    },
    methods: {
        fetchStatuses(){ // Get all statuses for the listing
          axios.get('/api/' + this.userslug + '/' + this.projectslug + '/statuses').then(response => {
              this.statuses = response.data.data;
              this.statuses.reverse();
          });
        },
        previewThumbnail: function(event) {
            var input = event.target;
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                var vm = this;
                reader.onload = function(e) {
                    vm.imageSrc = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
            this.newStatus.image = input.files[0];
        },
        createStatus(e){
          var formData = new FormData(e.target);
          formData.append('image', this.newStatus.image);
          formData.append('description', this.newStatus.description);
          formData.append('project_id', this.newStatus.project_id);
          formData.append('userslug', this.userslug);
          axios.post('/api/' + this.userslug + '/' + this.projectslug + '/statuses', formData).then(response => {
              this.fetchStatuses();
          }, response => {
              this.formErrors = response.data;
          });
          this.newStatus = {'description':''};
          $("#newStatusModal").modal("hide");
        },
        fetchStatus(status) { // Get individual status for editing
          axios.get('/api/' + this.userslug + '/' + this.projectslug + '/statuses/' + status.id).then(response => {
            this.editStatus.description = response.data.data[0].description;
            this.editStatus.id = response.data.data[0].id;
            this.editStatus.image = response.data.data[0].image;
            $("#updateStatusModal").modal("show");
          }, response => {
              this.formErrors = response.data;
          });
        },
        updateStatus(editStatus){
            axios.patch('/api/' + this.userslug + '/' + this.projectslug + '/statuses/' + this.editStatus.id, this.editStatus).then(response => {
              console.log(response);
              this.fetchStatuses();
            }, response => {
                console.log('fail');
            });
            $("#updateStatusModal").modal("hide");

        },
        deleteStatus(status){
              axios.delete('/api/' + this.userslug + '/' + this.projectslug + '/statuses/' + status.id).then(response => {
                   let index = this.statuses.indexOf(status);
                   this.statuses.splice(index, 1);
                  this.fetchStatuses();
              });
          },
    } // end methods
}
</script>
