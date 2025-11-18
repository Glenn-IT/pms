# Banner Slideshow Feature - User Guest Page

## Overview

A beautiful, interactive banner slideshow has been added to the user guest page (`user/guest.php`) with navigation thumbnails below the main banner.

## Features Implemented

### 🎨 Main Features

1. **Main Banner Display**

   - Large banner area (450px height on desktop)
   - Smooth fade transitions between banners
   - Banner information overlay (title & description)
   - Gradient overlay for better text readability

2. **Navigation Controls**

   - **Previous/Next Buttons**: Circular buttons on left/right
   - **Thumbnail Navigation**: Click any thumbnail to jump to that banner
   - **Auto-play**: Banners rotate every 5 seconds automatically
   - **Manual Control**: Auto-play pauses when user interacts, resumes after 5 seconds

3. **Thumbnail Bar**

   - Horizontal scrollable thumbnail strip
   - Active banner highlighted with border
   - Hover effects with overlay text
   - Smooth scrolling to center active thumbnail

4. **Responsive Design**
   - Desktop: 450px height
   - Tablet: Optimized layout
   - Mobile: 300px height (768px and below)
   - Small Mobile: 250px height (480px and below)

## Visual Design

### Layout Structure

```
┌─────────────────────────────────────┐
│                                     │
│        Main Banner (450px)          │
│      with Overlay Info              │
│    ← Prev         Next →            │
│                                     │
├─────────────────────────────────────┤
│  [Thumb] [Thumb] [Active] [Thumb]  │
│       Scrollable Thumbnails         │
└─────────────────────────────────────┘
```

### Color Scheme

- **Active Thumbnail Border**: #001f3f (Navy Blue)
- **Navigation Buttons**: White with Navy Blue icon
- **Overlay Background**: Black gradient (transparent to 80%)
- **Thumbnail Background**: #f8f9fa (Light Gray)

## How It Works

### Data Loading

1. Fetches active banners from database via AJAX
2. Only displays banners with `status = 1` (Active)
3. If no banners exist, section remains hidden

### Auto-play Behavior

- **Interval**: 5 seconds between transitions
- **Pause on Interaction**: Stops when user clicks prev/next or thumbnail
- **Resume**: Auto-play restarts 5 seconds after last interaction
- **Single Banner**: Auto-play disabled if only 1 banner exists

### User Interactions

1. **Click Prev/Next**: Immediate navigation, stops auto-play temporarily
2. **Click Thumbnail**: Jump to specific banner, stops auto-play temporarily
3. **Hover Thumbnail**: Shows banner title overlay
4. **Mobile Swipe**: Currently not implemented (future enhancement)

## Technical Implementation

### Files Modified

- `user/guest.php` - Added banner slideshow section and functionality

### CSS Classes Added

```css
.banner-section
  -
  Main
  container
  .banner-slideshow
  -
  Slideshow
  wrapper
  .main-banner-container
  -
  Main
  banner
  display
  area
  .banner-slide
  -
  Individual
  banner
  slide
  .banner-info
  -
  Title/description
  overlay
  .banner-nav
  -
  Prev/Next
  buttons
  .thumbnail-container
  -
  Thumbnail
  bar
  .banner-thumbnail
  -
  Individual
  thumbnail;
```

### JavaScript Functions

```javascript
loadBanners()           - Fetch active banners from database
displayBanners()        - Render banner slideshow HTML
changeBanner(direction) - Navigate prev/next (-1 or +1)
selectBanner(index)     - Jump to specific banner
updateBannerDisplay()   - Update active states
startBannerAutoplay()   - Begin auto-rotation
stopBannerAutoplay()    - Pause auto-rotation
```

### API Endpoint Used

```
GET: classes/Master.php?f=get_active_banners
Returns: Active banners (status = 1) ordered by date
```

## Responsive Breakpoints

| Screen Size | Banner Height | Thumbnail Size | Navigation Button |
| ----------- | ------------- | -------------- | ----------------- |
| Desktop     | 450px         | 150x100px      | 50x50px           |
| Tablet      | 450px         | 150x100px      | 50x50px           |
| Mobile      | 300px         | 100x70px       | 40x40px           |
| Small       | 250px         | 80x60px        | 40x40px           |

## Usage Instructions

### For Administrators

1. Add banners in the admin panel (`admin/?page=banner/index`)
2. Set banner status to **Active** for it to appear on guest page
3. Upload high-quality images (recommended: 1920x600px)
4. Add title and description for better context

### For Users

1. Visit the guest page (`user/guest.php`)
2. Banner slideshow appears automatically (if active banners exist)
3. Click thumbnails to view specific banners
4. Use prev/next arrows for navigation
5. Wait for auto-rotation (5 seconds per banner)

## Future Enhancements

### Phase 2

- [ ] Touch/swipe support for mobile devices
- [ ] Keyboard navigation (arrow keys)
- [ ] Pause button for auto-play
- [ ] Progress indicators/dots
- [ ] Banner count indicator (e.g., "1 of 5")

### Phase 3

- [ ] Full-screen view mode
- [ ] Zoom on image click
- [ ] Video banner support
- [ ] Link/CTA buttons on banners
- [ ] Transition effects (slide, zoom, fade variations)

## Browser Compatibility

✅ Chrome 90+
✅ Firefox 88+
✅ Safari 14+
✅ Edge 90+
✅ Mobile Browsers (iOS Safari, Chrome Mobile)

## Performance Considerations

- **Lazy Loading**: Images load only when needed
- **Auto-play Management**: Stops when not visible
- **Smooth Animations**: CSS transitions (GPU accelerated)
- **Thumbnail Scrolling**: Smooth native scrollbar

## Troubleshooting

### Banners not showing?

1. Check if any banners are marked as "Active" in admin panel
2. Verify banner images exist in `uploads/banners/`
3. Check browser console for JavaScript errors

### Auto-play not working?

1. Ensure multiple banners exist (needs 2+ for auto-play)
2. Check if page is in focus (some browsers pause timers)
3. Verify JavaScript is enabled

### Thumbnails not scrolling?

1. Check if more than 4-5 thumbnails exist
2. Verify CSS overflow-x is set to auto
3. Test on different browsers

## Accessibility

- ✅ Keyboard accessible (tab navigation)
- ✅ ARIA labels on navigation buttons
- ✅ Alt text on images (uses banner title)
- ✅ High contrast overlays for readability
- ⚠️ Screen reader support (future improvement)

## Testing Checklist

- [x] Load banners from database
- [x] Display main banner with overlay
- [x] Previous/Next navigation
- [x] Thumbnail click navigation
- [x] Auto-play rotation
- [x] Active thumbnail highlighting
- [x] Responsive on mobile
- [x] Smooth transitions
- [x] Hide section when no banners

## Summary

The banner slideshow provides a professional, engaging way to showcase important information on the guest page. It's fully integrated with the admin banner management system and requires no additional configuration beyond adding active banners.

**Status**: ✅ Complete and Ready to Use!

**Page**: `http://localhost/pms/user/guest.php`
