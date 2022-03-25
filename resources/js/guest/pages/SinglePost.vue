<template>
  <div class="tot">
        <div>TITOLO: {{post.title}}</div>
        <div>CONTENUTO: {{post.content}}</div>
        <div v-if="post.category">CATEGORIA: {{post.category.name}}</div>
        <ul v-if="post.tags">
            TAG: <li v-for="tag in post.tags" :key="tag.slug">{{tag.name}}</li>
        </ul>
    </div>
</template>

<script>
export default {
    name: "SinglePost",
    data() {
      return {
        post: {},
      };
    },
    created(){
        axios
        .get(`/api/posts/${this.$route.params.slug}`)
        .then((apirisp)=>{
            this.post= apirisp.data;
            console.log(this.post);
        })
    }
}
</script>

<style scoped>
.tot{
    margin: 20px 0px;
}
ul{
    list-style: none;
  }
  li{
    margin-bottom: 20px;
  }
</style>