# bcit-comp-4016
## BCIT COMP 4106 - Applied DevOps with Kubernetes

### ASSIGNMENT 1

**Directory**
```
a1
```
**Image**
```
docker pull ravinderjit/assignment1
```
**Container**
```
docker run -d -p 8080:8080 ravinderjit/assignment1
```
**cURL HTTP**
```
curl localhost:8080/foo
```
```
curl -H "Accept: application/json" -H "Content-Type: application/json" -X POST --data '{"name": "Prabh"}' localhost:8080/hello
```
```
curl localhost:8080/kill
```
**Note(s)**
```
- cURL HTTP responses are appended with '\n' - e.g., curl localhost:8080/foo will return "bar\n"
```
### ASSIGNMENT 2

**Directory**
```
a2
```
**Image**
```
docker.io/ravinderjit/assignment2:latest
```
**Kubernetes Manifest**
```
k8s-config.yaml
```
**Command(s)**
```
kubectl apply -f k8s-config.yaml
kubectl get all -n rgill201
```
**cURL HTTP**
```
curl localhost:30000/configValue
```
```
curl localhost:30000/secretValue
```
```
curl localhost:30000/envValue
```
### ASSIGNMENT 3

**Directory**
```
a3
```
**Image**
```
docker.io/ravinderjit/assignment3:latest
```
**Kubernetes Manifest**
```
k8s-manifest.yaml
```
**Command(s)**
```
kubectl apply -f k8s-config.yaml
kubectl get all -n rgill201
kubectl get all -n probe
```
**cURL HTTP**
```
curl -H "Content-Type: application/json" -X POST --data '{"data": "savedSnake"}' localhost:30000/saveString
```
```
curl localhost:30000/getString
```
