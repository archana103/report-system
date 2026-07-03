import { h } from 'vue'

export const iconBase = { viewBox: '0 0 24 24', fill: 'none', stroke: 'currentColor', 'stroke-width': '1.8' }
export const icon = (paths, className = 'icon') => () => h('svg', { ...iconBase, class: className, 'aria-hidden': 'true' }, paths.map((d) => h('path', { d, 'stroke-linecap': 'round', 'stroke-linejoin': 'round' })))

export const ArrowRight = icon(['m9 18 6-6-6-6'])
export const ArrowLeft = icon(['m15 18-6-6 6-6'])
export const CircleArrow = () => h(
  'svg',
  { viewBox: "0 0 512 512", class: "small-icon", style: "fill: currentColor; stroke: none; width: 18px; height: 18px;", 'aria-hidden': 'true' },
  [
    h('path', { d: "M165.013,288.946h75.034c6.953,0,12.609,5.656,12.609,12.608v26.424c0,7.065,3.659,9.585,7.082,9.585 c2.106,0,4.451-0.936,6.78-2.702l90.964-69.014c3.416-2.589,5.297-6.087,5.297-9.844c0-3.762-1.881-7.259-5.297-9.849 l-90.964-69.014c-2.329-1.766-4.674-2.702-6.78-2.702c-3.424,0-7.082,2.519-7.082,9.584v26.425c0,6.952-5.656,12.608-12.609,12.608 h-75.034c-8.707,0-15.79,7.085-15.79,15.788v34.313C149.223,281.862,156.305,288.946,165.013,288.946z" }),
    h('path', { d: "M256,0C114.842,0,0.002,114.84,0.002,256S114.842,512,256,512c141.158,0,255.998-114.84,255.998-256 S397.158,0,256,0z M256,66.785c104.334,0,189.216,84.879,189.216,189.215S360.334,445.215,256,445.215S66.783,360.336,66.783,256 S151.667,66.785,256,66.785z" })
  ]
)
export const IconChart = icon(['M4 19V5', 'M8 17v-5', 'M12 17V8', 'M16 17v-7', 'M20 17v-3'])
export const IconUsers = icon(['M16 21v-2a4 4 0 0 0-4-4H7a4 4 0 0 0-4 4v2', 'M9.5 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8', 'M22 21v-2a4 4 0 0 0-3-3.87', 'M16 3.13a4 4 0 0 1 0 7.75'])
export const IconSliders = icon(['M4 21v-7', 'M4 10V3', 'M12 21v-9', 'M12 8V3', 'M20 21v-5', 'M20 12V3', 'M2 14h4', 'M10 8h4', 'M18 16h4'])
export const IconTarget = icon(['M12 21a9 9 0 1 0-9-9 9 9 0 0 0 9 9Z', 'M12 17a5 5 0 1 0-5-5 5 5 0 0 0 5 5Z', 'M12 13a1 1 0 1 0-1-1 1 1 0 0 0 1 1Z', 'M20 4l-5.5 5.5'])
export const IconBrief = icon(['M10 6V5a2 2 0 0 1 2-2h0a2 2 0 0 1 2 2v1', 'M4 7h16v13H4z', 'M9 12h6'])
export const IconTrend = icon(['M4 17 10 11l4 4 6-8', 'M14 7h6v6'])
export const IconBulb = icon(['M9 18h6', 'M10 22h4', 'M8 14a6 6 0 1 1 8 0c-.9.8-1.3 1.7-1.4 3H9.4c-.1-1.3-.5-2.2-1.4-3Z'])
export const IconPin = icon(['M12 21s7-4.5 7-11a7 7 0 1 0-14 0c0 6.5 7 11 7 11Z', 'M12 10.5a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z'])
export const IconMail = icon(['M4 6h16v12H4z', 'm4 7 8 6 8-6'])
export const PhoneMini = icon(['M22 16.92v3a2 2 0 0 1-2.18 2 19.8 19.8 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.12 4.18 2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.96.35 1.9.66 2.8a2 2 0 0 1-.45 2.11L8.05 9.9a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.9.31 1.84.53 2.8.66A2 2 0 0 1 22 16.92Z'])
export const IconDatabase = icon(['M21 12c0 1.66-4 3-9 3s-9-1.34-9-3', 'M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5', 'M21 5c0 1.66-4 3-9 3s-9-1.34-9-3 4-3 9-3 9 1.34 9 3z'])
export const IconSearch = icon(['M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z'])
export const IconShieldCheck = icon(['M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z'])
export const IconChartUp = icon(['M3 3v18h18', 'M18.7 8l-5.1 5.2-2.8-2.7L7 14.3'])
export const IconFileText = icon(['M9 12h6M9 16h6M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6z'])
export const IconArrowUp = icon(['M12 19V5', 'm5 12 7-7 7 7'])