import { ref, computed } from 'vue'

const isExpanded = ref(true)
const isMobile = ref(false)

export function useSidebar() {
  const toggleSidebar = () => {
    isExpanded.value = !isExpanded.value
  }

  const handleResize = () => {
    const width = window.innerWidth
    isMobile.value = width < 1024
    
    if (width < 768) {
      // Mobile: sempre expandido quando visível
      isExpanded.value = true
    } else if (width < 1024) {
      // Tablet: comprimido por padrão
      isExpanded.value = false
    } else if (width < 1280) {
      // Desktop pequeno: comprimido por padrão
      isExpanded.value = false
    } else {
      // Desktop grande: expandido por padrão
      isExpanded.value = true
    }
  }

  const sidebarWidth = computed(() => {
    return isExpanded.value ? 'w-64' : 'w-16'
  })

  return {
    isExpanded,
    isMobile,
    toggleSidebar,
    handleResize,
    sidebarWidth
  }
}