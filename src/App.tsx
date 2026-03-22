import { useEffect, useState } from 'react'
import styles from './App.module.css'

interface HelloassoForm {
  banner: {
    fileName: string
    publicUrl: string
  }
  currency: string
  description: string
  startDate: string
  endDate: string
  meta: {
    createdAt: string
    updatedAt: string
  }
  title: string
  formSlug: string
  url: string
}

function App() {
  const [forms, setForms] = useState<HelloassoForm[]>([])

  useEffect(() => {
    const fetchDatas = async () => {
      try {
        const apiUrl = import.meta.env.VITE_API_URL
        const response = await fetch(`${apiUrl}/forms`)
        const data = await response.json()
        setForms(data)
      } catch (error) {
        console.error('Error fetching forms:', error)
      }
    }

    fetchDatas()
  }, [])

  return (
    <>
      <div className={styles.cardGrid}>
        {forms.map((form) => (
          <div key={form.formSlug} className={styles.formCard}>
            {form.banner?.publicUrl && (
              <img
                src={`${import.meta.env.VITE_API_URL}/proxy-image?url=${encodeURIComponent(
                  form.banner.publicUrl,
                )}`}
                alt={form.title}
                className={styles.formBanner}
              />
            )}
            <div className={styles.formContent}>
              <h2>{form.title}</h2>
              <p>{form.description}</p>
              <div className={styles.formFooter}>
                <span>{new Date(form.startDate).toLocaleDateString()}</span>
                <a href={form.url} target="_blank" rel="noreferrer" className={styles.ctaButton}>
                  Participer
                </a>
              </div>
            </div>
          </div>
        ))}
      </div>
    </>
  )
}

export default App
