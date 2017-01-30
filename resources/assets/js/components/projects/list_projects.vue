<template>
    <div>

        <div class="text-center">

          <div v-if="projects.length > 0">
            <li v-for="project in projects">
            <a :href="'/profile/' + userslug + '/' + project.slug">{{project.name}}</a>
            </li>
          </div>
          <div v-else>
            No active projects
          </div>

          {{newProject.name}}<br/>
          <form v-on:submit.prevent="createProject" method="post" enctype="multipart/form-data">

            <input
                        v-model="newProject.name"
                        type="text"
                        class="form-control"
                        id="name"
                        placeholder="Name...">
            <input
                        v-model="newProject.description"
                        type="text"
                        class="form-control"
                        id="description"
                        placeholder="Description...">
            <input
                        v-model="newProject.slug"
                        type="text"
                        class="form-control"
                        id="slug"
                        placeholder="slug...">
            <input
                        v-model="newProject.source"
                        type="text"
                        class="form-control"
                        id="source"
                        placeholder="source...">
            <input
                        v-model="newProject.user_id"
                        type="text"
                        class="form-control"
                        id="userid"
                        placeholder="user_id...">
        <div class="form-group">
              <button type="submit" class="btn btn-primary">Create New Project</button>
          </div>
        </form>
        </div>
    </div>
</template>

<script>
export default {
  props: {
      userslug: {
            type: String,
            default: "",
        }
    },
    data() {
        return {
            projects : [],
            newProject: {
              name: 'new project',
              description: 'this is a new project',
              source: 'bbc',
              slug: 'new-project',
              user_id: '11'
            }
        }
    },
    mounted(){
        this.getProjects();
    },
    methods : {
        getProjects(){
            axios.get('/api/' + this.userslug + '/projects_list')
                .then((response) => {
                    let projects = response.data;
                    this.projects = projects.projects;
                })
        },
        createProject: function() {
      var input = this.newProject;
      axios.post('/api/projects',input).then((response) => {
        console.log(input);
      }, (response) => {
        console.log(input);
      });

      // axios({
      //   method: 'post',
      //   url: '/api/projects',
      //   headers: header,
      //   data: {
      //     name: 'new project',
      //     description: 'this is a new project',
      //     source: 'bbc',
      //     slug: 'new-project',
      //     user_id: '11'
      //   }
      //});
    }
}
}
</script>
