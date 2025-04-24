import type { App } from 'vue'
import { Quasar, Dialog, Notify,     QLayout,
  QHeader,
  QFooter,
  QDrawer,
  QPageContainer,
  QPage,
  QToolbar,
  QToolbarTitle,
  QBtn,
  QIcon,
  QTable,
  QTh,
  QTr,
  QTd,
  QInput,
  QForm,
  QFile,
  QCard,
  QCardSection,
  QCardActions,
  QImg,
  QSpace} from 'quasar'
import quasarLang from 'quasar/lang/en-US'
import 'quasar/dist/quasar.css'
import '@quasar/extras/material-icons/material-icons.css'

export default (app: App): void => {
  app.use(Quasar, {
    plugins: {Dialog, Notify, QBtn },
    lang: quasarLang,
    components: {     QLayout,
      QHeader,
      QFooter,
      QDrawer,
      QPageContainer,
      QPage,
      QToolbar,
      QToolbarTitle,
      QBtn,
      QIcon,
      QTable,
      QTh,
      QTr,
      QTd,
      QInput,
      QForm,
      QFile,
      QCard,
      QCardSection,
      QCardActions,
      QImg,
      QSpace} 
  })
}
