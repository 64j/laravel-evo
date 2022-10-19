<template>
  <div class="actions-buttons position-fixed rounded-bottom bg-opacity-10 bg-secondary p-2">
    <div class="btn-group btn-group-sm">
      <button type="button" class="btn btn-light btn-outline-secondary shadow-none" @click="$emit('action', 'cancel', $event)" :title="$store.state['Settings'].lang('cancel')">
        <i class="fa fa-reply fa-fw"/>
        <span>{{ $store.state['Settings'].lang('cancel') }}</span>
      </button>
      <button type="button" class="btn btn-danger shadow-none" @click="$emit('action', 'delete', $event)" :title="$store.state['Settings'].lang('delete')">
        <i class="fa fa-trash-alt fa-fw"/>
        <span>{{ $store.state['Settings'].lang('delete') }}</span>
      </button>
      <button type="button" class="btn btn-success shadow-none" @click="$emit('action', 'save', $event)" :title="$store.state['Settings'].lang('save')">
        <i class="fa fa-save fa-fw"/>
        <span>{{ $store.state['Settings'].lang('save') }}</span>
      </button>
    </div>
  </div>
</template>

<script>
export default {
  name: 'ActionsButtons'
}
</script>

<style scoped>
.actions-buttons { top: 5rem; right: 0; }
.btn span { display: none }
</style>
