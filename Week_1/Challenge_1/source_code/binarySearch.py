def binary_search(nums, target):
    left, right = 0, len(nums) - 1 
          
    while left<=right:
        middle = left+(right-left)//2   
        if nums[middle] == target:      
            return middle+1
        elif nums[middle]>target:      
            right = middle -1
        else:
            left = middle +1                  
    return -1                        

nums = list(map(int, input().split(" ")))
target = int(input())
nums.sort()
print(binary_search(nums=nums,target=target))