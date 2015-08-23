
Set objUser = GetObject ("LDAP://cn={CN},{OUDC}") 
objUser.Put "physicalDeliveryOfficeName", "{ROOM}" 
objUser.Put "title", "{TITLE}"
objUser.Put "department", "{DEPARTMENT}"
objUser.SetInfo