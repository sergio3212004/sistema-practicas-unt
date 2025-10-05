from django.urls import path
# views
from .views import CustomTokenRefreshView, CustomTokenObtainPairView, logout_view, profile_view, register_view

urlpatterns = [
    path('register/', register_view, name='register'),
    path('login/', CustomTokenObtainPairView.as_view(), name='login'),
    path('refresh/', CustomTokenRefreshView.as_view(), name='refresh'),
    path('logout/', logout_view, name='logout'),
    path('profile/', profile_view, name='profile'),

]