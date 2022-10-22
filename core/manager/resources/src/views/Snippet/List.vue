<template>
  <Panel
    :data="data"
    :actions="actions"
    :search-input="true"
    link-name="SnippetIndex"
    link-icon="fa fa-code"
    :txt-new="lang('new_snippet')"
    :txt-help="lang('snippet_management_msg')"
    @action="action"
  />
</template>

<script>
import http from '@/utils/http'
import Panel from '@/components/Panel'

export default {
  name: 'SnippetList',
  components: { Panel },
  data () {
    this.element = 'SnippetIndex'
    this.controller = 'Snippet'

    return {
      data: null,
      actions: {
        copy: {
          icon: 'far fa-clone fa-fw',
          title: this.$store.state['Settings'].lang('duplicate')
        },
        disabled: {
          values: {
            0: {
              icon: 'far fa-times-circle text-danger',
              title: this.$store.state['Settings'].lang('disabled')
            },
            1: {
              icon: 'far fa-check-circle text-success',
              title: this.$store.state['Settings'].lang('enabled')
            }
          }
        },
        delete: {
          icon: 'fa fa-trash fa-fw text-danger',
          title: this.$store.state['Settings'].lang('delete')
        }
      }
    }
  },
  mounted () {
    http.list(this.controller, { categories: true }).then(result => this.data = result.data)
  },
  methods: {
    action (action, item, category) {
      switch (action) {
        case 'copy':
          http.copy(this.controller, item).then(result => {
            if (result) {
              this.list()
            }
          })
          break

        case 'delete':
          http.delete(this.controller, item).then(result => {
            if (result) {
              delete category.items[item.id]
              this.$root.$refs.Layout.$refs.MultiTabs.closeTab(this.$router.resolve({ name: this.element, params: { id: item.id } }))
            }
          })
          break

        case 'disabled':
          item.disabled = item.disabled ? 0 : 1
          break
      }
    }
  }
}
</script>
