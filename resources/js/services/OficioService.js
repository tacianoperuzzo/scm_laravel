import api from '@/services/api'
export default {

  deletePreview(file) {
    api.post('api/oficio/deletepreview', {file: file}).then(()=>{})
  }
}
