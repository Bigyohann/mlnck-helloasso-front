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
        {forms.map((form) => {
          const now = new Date()
          const isEnded = new Date(form.endDate) < now
          const isUpcoming = new Date(form.startDate) > now

          return (
            <div key={form.formSlug} className={styles.formCard}>
              <div className={styles.bannerWrapper}>
                {form.banner?.publicUrl && (
                  <img
                    src={`${import.meta.env.VITE_API_URL}/proxy-image?url=${encodeURIComponent(
                      form.banner.publicUrl,
                    )}`}
                    alt={form.title}
                    className={styles.formBanner}
                  />
                )}
                <span
                  className={`${styles.statusBadge} ${
                    isEnded ? styles.ended : isUpcoming ? styles.upcoming : styles.active
                  }`}
                >
                  {isEnded ? 'Terminé' : isUpcoming ? 'À venir' : 'En cours'}
                </span>
              </div>
              <div className={styles.formContent}>
                <h2>{form.title}</h2>
                <p className={styles.description}>{form.description}</p>
                <div className={styles.formDates}>
                  <div className={styles.dateRow}>
                    <span className={styles.dateIcon}>📅</span>
                    <span className={styles.dateLabel}>Début :</span>
                    <span className={styles.dateValue}>
                      {new Date(form.startDate).toLocaleString(undefined, {
                        dateStyle: 'short',
                        timeStyle: 'short',
                      })}
                    </span>
                  </div>
                  <div className={styles.dateRow}>
                    <span className={styles.dateIcon}>🏁</span>
                    <span className={styles.dateLabel}>Fin :</span>
                    <span className={styles.dateValue}>
                      {new Date(form.endDate).toLocaleString(undefined, {
                        dateStyle: 'short',
                        timeStyle: 'short',
                      })}
                    </span>
                  </div>
                </div>
                <div className={styles.formFooter}>
                  <a href={form.url} target="_blank" rel="noreferrer" className={styles.ctaButton}>
                    {isEnded ? 'Voir les détails' : 'Participer'}
                  </a>
                </div>
              </div>
            </div>
          )
        })}
      </div>
    </>
  )
}

export default App
