<template>
  <q-page class="q-pa-md">
    <q-btn label="New User" color="primary" @click="openCreate" class="q-mb-md" />
    <UserForm v-if="showForm" :edit-user="selectedUser" :onSaved="loadUsers" />

    <q-table :rows="userResponse.data" :columns="columns" row-key="id" v-model:pagination="pagination"
      @request="onRequest" flat>
      <template #body-cell-profile_picture="props">
        <q-td>
          <q-img :src="getProfilePictureUrl(props.row.profile_picture)"
            style="width: 100px; height: 100px; border-radius: 8px;" spinner-color="white" :ratio="1" />
        </q-td>
      </template>

      <template #body-cell-actions="props">
        <q-td>
          <q-btn icon="edit" size="sm" @click="editUser(props.row)" />
          <q-btn icon="delete" size="sm" color="negative" @click="removeUser(props.row.id)" />
        </q-td>
      </template>
    </q-table>

  </q-page>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { getUsers, deleteUser } from './../../services/UserService'
import UserForm from './../../components/UserForm.vue'
import { Dialog } from 'quasar'


const userResponse = ref({
  data: [],
  total: 0,
  per_page: 10,
  current_page: 1
})

const pagination = ref({
  page: 1,
  rowsPerPage: 10,
  rowsNumber: 0
})

const showForm = ref(false)
const selectedUser = ref(null)

const columns = [
  { name: 'profile_picture', label: 'Profile Picture', field: 'profile_picture', align: 'left' },
  { name: 'name', label: 'Name', field: 'name', align: 'left' },
  { name: 'email', label: 'Email', field: 'email', align: 'left' },
  { name: 'phone_number', label: 'Phone Number', field: 'phone_number', align: 'left' },
  { name: 'address', label: 'Address', field: 'address', align: 'left' },
  { name: 'age', label: 'Age', field: 'age', align: 'left' },
  { name: 'actions', label: 'Actions', field: 'actions', align: 'center' }
]

const getProfilePictureUrl = (path: string) => {
  return path ? `${import.meta.env.VITE_API_BASE_URL}/storage/${path}` : ''
}

const onRequest = (params: any) => {
  pagination.value = {
    ...pagination.value,
    page: params.pagination.page,
    rowsPerPage: params.pagination.rowsPerPage
  }
  loadUsers()
}

const loadUsers = async () => {
  const res = await getUsers(pagination.value.page, pagination.value.rowsPerPage)
  userResponse.value = res.data

  pagination.value.rowsNumber = res.data.total
}

const openCreate = () => {
  selectedUser.value = null
  showForm.value = !showForm.value;
}

const editUser = (user: any) => {
  selectedUser.value = user
  showForm.value = true
}

const removeUser = async (id: number) => {
  Dialog.create({
    title: 'Confirm',
    message: 'Are you sure you want to delete this user?',
    cancel: true,
    persistent: true
  }).onOk(async () => {
    await deleteUser(id)

    // go back a page if this was the last item
    if (userResponse.value.data.length === 1 && pagination.value.page > 1) {
      pagination.value.page--
    }

    await loadUsers()
  })
}

onMounted(loadUsers)
</script>
