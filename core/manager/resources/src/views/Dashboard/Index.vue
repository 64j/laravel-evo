<template>
  <div class="container-fluid py-2">
    <h1>{{ title }}</h1>
  </div>
</template>

<script>
export default {
  name: 'DashboardIndex',
  computed: {
    title () {
      return this.$store.state['Settings'].lang('home')
    }
  }
}
</script>

<style scoped>

</style>
