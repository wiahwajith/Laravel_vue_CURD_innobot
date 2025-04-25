<template>
<q-page class="q-pa-md bg-grey-1">
  <div class="q-gutter-y-md">

    <div class="flex justify-between items-center">
      <div class="text-h6 text-primary">User Management</div>
      <q-btn label="New User" color="primary" icon="person_add" unelevated @click="openCreate" />
    </div>

    <q-card flat bordered class="q-pa-md">
      <UserForm
        v-if="showForm"
        :edit-user="selectedUser"
        :on-saved="handleFormSaved"
      />
    </q-card>

    <q-card flat bordered class="q-pa-md">
      <q-table
        :rows="userResponse.data"
        :columns="columns"
        row-key="id"
        v-model:pagination="pagination"
        @request="onRequest"
        flat
        bordered
        wrap-cells
        class="shadow-1"
      >
        <template #body-cell-profile_picture="props">
          <q-td class="text-center">
            <q-img
              :src="getProfilePictureUrl(props.row.profile_picture)"
              class="rounded-borders"
              style="width: 60px; height: 60px"
              spinner-color="primary"
              :ratio="1"
              fit="cover"
            />
          </q-td>
        </template>

        <template #body-cell-actions="props">
          <q-td class="text-center">
            <q-btn icon="edit" size="sm" flat color="primary" @click="editUser(props.row)" round />
            <q-btn icon="delete" size="sm" flat color="negative" @click="removeUser(props.row.id)" round />
          </q-td>
        </template>
      </q-table>
    </q-card>

  </div>
</q-page>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { getUsers, deleteUser } from '@/services/UserService'
import UserForm from '@/components/user/UserForm.vue'
import { Dialog, Notify } from 'quasar'

interface User {
  id: number
  name: string
  email: string
  phone_number: string
  address: string
  age: number
  profile_picture: string
}

// State
const showForm = ref(false)
const selectedUser = ref<User | null>(null)

const userResponse = ref({
  data: [] as User[],
  total: 0,
  per_page: 10,
  current_page: 1
})

const pagination = ref({
  page: 1,
  rowsPerPage: 10,
  rowsNumber: 0
})

// Table Columns
const columns = [
  { name: 'profile_picture', label: 'Profile Picture', field: 'profile_picture', align: 'left' },
  { name: 'name', label: 'Name', field: 'name', align: 'left' },
  { name: 'email', label: 'Email', field: 'email', align: 'left' },
  { name: 'phone_number', label: 'Phone Number', field: 'phone_number', align: 'left' },
  { name: 'address', label: 'Address', field: 'address', align: 'left' },
  { name: 'age', label: 'Age', field: 'age', align: 'left' },
  { name: 'actions', label: 'Actions', field: 'actions', align: 'center' }
]

// Utils
const getProfilePictureUrl = (path: string) =>
  path ? `${import.meta.env.VITE_API_BASE_URL}/storage/${path}` : ''

// API
const loadUsers = async () => {
  try {
    const res = await getUsers(pagination.value.page, pagination.value.rowsPerPage)
    userResponse.value = res.data.data
    pagination.value.rowsNumber = res.data.data.total
  } catch (err) {
    Notify.create({ type: 'negative', message: 'Failed to load users' })
  }
}

// Actions
const openCreate = () => {
  selectedUser.value = null
  showForm.value = !showForm.value;
}

const editUser = (user: User) => {
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
    try {
      await deleteUser(id)

      // Go back a page if this was the last item
      if (userResponse.value.data.length === 1 && pagination.value.page > 1) {
        pagination.value.page--
      }

      await loadUsers()
      Notify.create({ type: 'positive', message: 'User deleted successfully' })
    } catch (err) {
      Notify.create({ type: 'negative', message: 'Failed to delete user' })
    }
  })
}

const handleFormSaved = async () => {
  showForm.value = false
  await loadUsers()
}

// Pagination Event
const onRequest = (params: any) => {
  pagination.value = {
    ...pagination.value,
    page: params.pagination.page,
    rowsPerPage: params.pagination.rowsPerPage
  }
  loadUsers()
}

// Init
onMounted(loadUsers)
</script>
