<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Example Component</div>

                    <div class="panel-body">
                      <div v-if="projects.length > 0">
                        <li v-for="project in projects">
                                {{project.name}}
                        </li>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
export default {
    data() {
        return {
            projects : [],
        }
    },
    created(){
        this.getProjects();
    },
    methods : {
        getProjects(){
            axios.get('api/all_projects')
                .then((response) => {
                    let projects = response.data;
                    this.projects = projects.data;
                    console.log(projects);
                })
                .catch(
                    (response) => {
                        console.log('error');
                        console.log(response.data);
                    }
                );
        }
    }
}
</script>
