<template>
  <div>

    <TitleView :title="title" icon="fa fa-th"/>

    <Tabs
      id="resources"
      :activeTab="activeTab"
      :history="history"
      :tabs="tabs"/>

  </div>
</template>

<script>
import TitleView from '@/components/Title'
import Tabs from '@/components/Tabs'

export default {
  name: 'ElementsIndex',
  components: { TitleView, Tabs },
  data () {
    return {
      activeTab: this.$route.query.resourcesTab || 0,
      history: true,
      tabs: [
        {
          id: 'Templates',
          title: this.$store.state['Settings'].lang('templates'),
          icon: 'fa fa-newspaper',
          component: () => import('@/views/Template/List'),
          hidden: !this.$store.state.Settings.permissions['edit_template']
        },
        {
          id: 'Variables',
          title: this.$store.state['Settings'].lang('tmplvars'),
          icon: 'fa fa-list-alt',
          component: () => import('@/views/Tv/List'),
          hidden: !this.$store.state.Settings.permissions['edit_template'] || !this.$store.state.Settings.permissions['edit_snippet'] || !this.$store.state.Settings.permissions['edit_chunk'] || !this.$store.state.Settings.permissions['edit_plugin']
        },
        {
          id: 'Chunks',
          title: this.$store.state['Settings'].lang('htmlsnippets'),
          icon: 'fa fa-th-large',
          component: () => import('@/views/Chunk/List'),
          hidden: !this.$store.state.Settings.permissions['edit_chunk']
        },
        {
          id: 'Snippets',
          title: this.$store.state['Settings'].lang('snippets'),
          icon: 'fa fa-code',
          component: () => import('@/views/Snippet/List'),
          hidden: !this.$store.state.Settings.permissions['edit_snippet']
        },
        {
          id: 'Plugins',
          title: this.$store.state['Settings'].lang('plugins'),
          icon: 'fa fa-plug',
          component: () => import('@/views/Plugin/List'),
          hidden: !this.$store.state.Settings.permissions['edit_plugin']
        },
        {
          id: 'Modules',
          title: this.$store.state['Settings'].lang('modules'),
          icon: 'fa fa-cubes',
          component: () => import('@/views/Module/List'),
          hidden: !this.$store.state.Settings.permissions['edit_module']
        }
      ],
    }
  },
  computed: {
    title () {
      return this.$store.state['Settings'].lang('elements')
    }
  },
  mounted () {
    this.$emit('titleTab', {
      title: this.title,
      icon: 'fa fa-th'
    })
  }
}
</script>
