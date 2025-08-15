# Event Duplicate Validation Documentation

## Overview

The Event Management System now includes duplicate validation to prevent events with the same title and time combination, regardless of the date.

## Validation Rules

### ✅ **Allowed Combinations**

1. **Same title + Different time**: Multiple events can have the same title as long as they have different times

   - Example: "Town Meeting" at 9:00 AM and "Town Meeting" at 2:00 PM ✅

2. **Different title + Same time**: Multiple events can have the same time as long as they have different titles

   - Example: "Town Meeting" at 9:00 AM and "Community Workshop" at 9:00 AM ✅

3. **Same title + Same time + Different date**: This is **NOT allowed** - the system ignores the date portion
   - Example: "Town Meeting" on 2025-08-15 at 9:00 AM and "Town Meeting" on 2025-08-16 at 9:00 AM ❌

### ❌ **Rejected Combinations**

- **Same title + Same time**: Events with identical titles and times are not allowed, regardless of the date
  - Example: "Town Meeting" at 9:00 AM and "Town Meeting" at 9:00 AM ❌

## Implementation Details

### Backend Validation (PHP)

- Located in: `classes/Master.php` - `save_event()` function
- Uses MySQL `TIME()` function to extract time portion from datetime
- Performs case-sensitive title comparison
- Excludes current event ID when editing existing events

### Frontend Validation (JavaScript)

- Located in: `admin/event/index.php`
- Real-time validation as user types
- Visual warning messages
- Prevents form submission for duplicates
- Case-insensitive title comparison for better user experience

### Database Query

```sql
SELECT id, title, date_created FROM event_list
WHERE title = 'Event Title'
AND TIME(date_created) = '09:00:00'
AND id != 'current_id' -- when editing
```

## User Experience

### Real-time Feedback

- Warning appears as soon as user enters conflicting title/time
- Warning automatically disappears when conflict is resolved
- Form submission is blocked until conflict is resolved

### Error Messages

- Clear, descriptive error messages
- Shows existing event details for reference
- Suggests specific actions (change title or time)

## Technical Notes

### Time Comparison

- System compares time in HH:MM:SS format
- Date portion (YYYY-MM-DD) is completely ignored
- Timezone considerations are handled by the database

### Performance

- Validation query is optimized with proper indexing
- Client-side validation reduces server requests
- Debounced input validation (300ms delay) prevents excessive checking

### Error Handling

- Graceful handling of invalid date formats
- Fallback behavior if DateTime parsing fails
- Console warnings for debugging

## Testing

Use the test script `test_duplicate_validation.php` to verify the validation logic with various scenarios.

## Future Enhancements

Potential improvements could include:

- Case-insensitive backend validation
- Fuzzy matching for similar titles
- Time range conflict detection
- Bulk import validation
- Administrative override options
